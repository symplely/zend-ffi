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
     * Invoke user handler.
     * For PHP 7.4:
     *
     * typedef `zval` *(*zend_object_get_property_ptr_ptr_t)(zval *object, zval *member, int type, void **cache_slot)
     *
     * For PHP 8+:
     *
     * typedef `zval` *(*zend_object_get_property_ptr_ptr_t)(zend_object *object, zend_string *member, int type, void **cache_slot);
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

        if (\IS_PHP74)
            $previousScope = ZendExecutor::fake_scope($object->value->obj->ce);
        else
            $previousScope = ZendExecutor::fake_scope($object->ce);

        $result = ($originalHandler)($object, $member, $type, $cacheSlot);
        ZendExecutor::fake_scope($previousScope);

        return $result;
    }
}
