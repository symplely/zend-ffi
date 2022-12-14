<?php

declare(strict_types=1);

namespace ZE\Hook;

use ZE\Zval;
use ZE\ZendExecutor;
use ZE\Hook\AbstractProperty;

/**
 * Receiving hook for casting to array, debugging, etc
 */
class GetPropertiesFor extends AbstractProperty
{
    protected const HOOK_FIELD = 'get_properties_for';

    /**
     * Invoke user handler.
     * For PHP 7.4:
     *
     * typedef `zend_array` *(*zend_object_get_properties_for_t)(zval *object, zend_prop_purpose purpose);
     *
     * For PHP 8+:
     *
     * typedef `zend_array` *(*zend_object_get_properties_for_t)(zend_object *object, zend_prop_purpose purpose);
     */
    public function handle(...$c_args)
    {
        [$this->object, $this->purpose] = $c_args;

        $result = ($this->userHandler)($this);
        $refValue = Zval::constructor($result);

        return $refValue->arr();
    }

    /**
     * Returns the purpose
     */
    public function purpose(): int
    {
        return $this->purpose;
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
        $purpose = $this->purpose;

        if (\IS_PHP74)
            $previousScope = ZendExecutor::fake_scope($object->value->obj->ce);
        else
            $previousScope = ZendExecutor::fake_scope($object->ce);

        $result = ($originalHandler)($object, $purpose);
        ZendExecutor::fake_scope($previousScope);

        return $result;
    }
}
