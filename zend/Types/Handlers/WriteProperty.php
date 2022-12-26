<?php

declare(strict_types=1);

namespace ZE\Hook;

use FFI\CData;
use ZE\Zval;
use ZE\ZendExecutor;
use ZE\Hook\AbstractProperty;

/**
 * Receiving hook for object field write operation
 */
class WriteProperty extends AbstractProperty
{
    protected const HOOK_FIELD = 'write_property';

    /**
     * typedef `zval` *(*zend_object_write_property_t)(zend_object *object, zend_string *member, zval *value, void **cache_slot);
     *
     * @inheritDoc
     */
    public function handle(...$c_args): CData
    {
        [$this->object, $this->member, $this->value, $this->cacheSlot] = $c_args;

        $result = ($this->userHandler)($this->object, $this->member, $this->value, $this->cacheSlot);
        Zval::init_value($this->value)->native_value($result);

        return $this->continue();
    }

    /**
     * Returns `value` to write
     *
     * @param mixed $newValue to set
     * @return mixed|void
     */
    public function value($newValue = null)
    {
        if (\is_null($newValue)) {
            Zval::init_value($this->value)->native_value($value);

            return $value;
        }

        Zval::init_value($this->value)->change_value($newValue);
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
        $value = $this->value;
        $cacheSlot = $this->cacheSlot;

        $previousScope = ZendExecutor::init()->fake_scope($object->ce);
        $result = ($originalHandler)($object, $member, $value, $cacheSlot);
        ZendExecutor::init()->fake_scope($previousScope);

        return $result;
    }
}
