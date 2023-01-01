<?php

declare(strict_types=1);

namespace ZE\Hook;

use ZE\ZendExecutor;
use ZE\Hook\AbstractProperty;

/**
 * Receiving hook for object field check operation
 */
class HasProperty extends AbstractProperty
{
    protected const HOOK_FIELD = 'has_property';

    /**
     * Invoke user handler.
     * For PHP 7.4:
     *
     * typedef `int` (*zend_object_has_property_t)(zval *object, zval *member, int has_set_exists, void **cache_slot);
     *
     * For PHP 8+:
     *
     * typedef `int` (*zend_object_has_property_t)(zend_object *object, zend_string *member, int has_set_exists, void **cache_slot);
     */
    public function handle(...$c_args): int
    {
        [$this->object, $this->member, $this->type, $this->cacheSlot] = $c_args;

        $result = ($this->userHandler)($this);

        return $result;
    }

    /**
     * Returns the check type:
     *  - 0 (has) whether property exists and is not NULL
     *  - 1 (set) whether property exists and is true
     *  - 2 (exists) whether property exists
     */
    public function check_type(): int
    {
        return $this->type;
    }

    /**
     * Proceeds with default handler
     */
    public function continue(): int
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
