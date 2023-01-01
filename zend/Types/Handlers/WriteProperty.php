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
     * Invoke user handler.
     * For PHP 7.4:
     *
     * typedef `zval` *(*zend_object_write_property_t)(zval *object, zval *member, zval *value, void **cache_slot);
     *
     * For PHP 8+:
     *
     * typedef `zval` *(*zend_object_write_property_t)(zend_object *object, zend_string *member, zval *value, void **cache_slot);
     */
    public function handle(...$c_args): CData
    {
        [$this->object, $this->member, $this->writeValue, $this->cacheSlot] = $c_args;

        $result = ($this->userHandler)($this);
        Zval::init_value($this->writeValue)->change_value($result);

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
            Zval::init_value($this->writeValue)->native_value($value);

            return $value;
        }

        Zval::init_value($this->writeValue)->change_value($newValue);
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
        $value = $this->writeValue;
        $cacheSlot = $this->cacheSlot;

        if (\IS_PHP74)
            $previousScope = ZendExecutor::fake_scope($object->value->obj->ce);
        else
            $previousScope = ZendExecutor::fake_scope($object->ce);

        $result = ($originalHandler)($object, $member, $value, $cacheSlot);
        ZendExecutor::fake_scope($previousScope);

        return $result;
    }
}
