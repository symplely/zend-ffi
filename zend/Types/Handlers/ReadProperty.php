<?php

declare(strict_types=1);

namespace ZE\Hook;

use FFI\CData;
use ZE\Zval;
use ZE\ZendExecutor;
use ZE\Hook\AbstractProperty;
use ZE\ZendString;

/**
 * Receiving hook for object field read operation
 */
class ReadProperty extends AbstractProperty
{
    protected const HOOK_FIELD = 'read_property';

    /**
     * typedef `zval` *(*zend_object_read_property_t)(zend_object *object, zend_string *member, int type, void **cache_slot, zval *rv);
     *
     * @inheritDoc
     */
    public function handle(...$c_args): CData
    {
        [$this->object, $this->member, $this->type, $this->cacheSlot, $this->rv] = $c_args;

        $result = ($this->userHandler)($this);
        $refValue = Zval::constructor($result);

        return $refValue();
    }

    /**
     * Returns the access type
     */
    public function access_type(): int
    {
        return $this->type;
    }

    /**
     * Proceeds with default handler
     */
    public function continue()
    {
        if (!$this->has_original()) {
            throw new \LogicException('Original handler is not available');
        }

        // As we will play with EG(fake_scope), we won't be able to access private or protected members, need to unpack
        $originalHandler = $this->originalHandler;

        $object = $this->object;
        $member = $this->member;
        $type = $this->type;
        $cacheSlot = $this->cacheSlot;
        $rv = $this->rv;

        $previousScope = ZendExecutor::fake_scope($object->ce);
        $result = ($originalHandler)($object, $member, $type, $cacheSlot, $rv);
        ZendExecutor::fake_scope($previousScope);

        Zval::init_value($result)->native_value($phpResult);

        return $phpResult;
    }
}
