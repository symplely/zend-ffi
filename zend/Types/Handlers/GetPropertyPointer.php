<?php

declare(strict_types=1);

namespace ZE\Hook;

use ZE\ZendExecutor;
use ZE\Hook\AbstractProperty;

/**
 * Receiving hook for indirect property access (by reference or via $this->field++)
 */
class GetPropertyPointer extends AbstractProperty
{
    protected const HOOK_FIELD = 'get_property_ptr_ptr';

    /**
     * typedef `zval` *(*zend_object_get_property_ptr_ptr_t)(zend_object *object, zend_string *member, int type, void **cache_slot)
     *
     * @inheritDoc
     */
    public function handle(...$c_args)
    {
        [$this->object, $this->member, $this->type, $this->cacheSlot] = $c_args;

        $result = ($this->userHandler)($this);

        return $result;
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

        $previousScope = ZendExecutor::init()->fake_scope($object->ce);
        $result = ($originalHandler)($object, $member, $type, $cacheSlot);
        ZendExecutor::init()->fake_scope($previousScope);

        return $result;
    }
}
