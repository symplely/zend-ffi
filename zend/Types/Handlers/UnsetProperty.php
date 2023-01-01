<?php

declare(strict_types=1);

namespace ZE\Hook;

use ZE\ZendExecutor;

/**
 * Receiving hook for object field unset operation
 */
class UnsetProperty extends AbstractProperty
{
    protected const HOOK_FIELD = 'unset_property';

    /**
     * Invoke user handler.
     * For PHP 7.4:
     *
     * typedef `void` (*zend_object_unset_property_t)(zval *object, zval *member, void **cache_slot);
     *
     * For PHP 8+:
     *
     * typedef `void` (*zend_object_unset_property_t)(zend_object *object, zend_string *member, void **cache_slot);
     */
    public function handle(...$c_args): void
    {
        [$this->object, $this->member, $this->cacheSlot] = $c_args;

        ($this->userHandler)($this);
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
        $cacheSlot = $this->cacheSlot;

        if (\IS_PHP74)
            $previousScope = ZendExecutor::fake_scope(ZendExecutor::init()->This()->obj()->ce);
        else
            $previousScope = ZendExecutor::fake_scope(ZendExecutor::init()->This()->ce());

        ($originalHandler)($object, $member, $cacheSlot);
        ZendExecutor::fake_scope($previousScope);
    }
}
