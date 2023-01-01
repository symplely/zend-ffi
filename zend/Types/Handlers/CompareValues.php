<?php

declare(strict_types=1);

namespace ZE\Hook;

use ZE\ObjectHandler;
use ZE\Zval;

/**
 * Receiving hook for performing operation on object
 */
class CompareValues extends ObjectHandler
{
    protected const HOOK_FIELD = 'compare';

    /**
     * Invoke user handler.
     * For PHP 7.4:
     *
     * typedef `int` (*zend_object_compare_zvals_t)(zval *result, zval *op1, zval *op2);
     *
     * For PHP 8+:
     *
     * typedef `int` (*zend_object_compare_t)(zval *object1, zval *object2);
     */
    public function handle(...$c_args): int
    {
        if (\IS_PHP74) {
            [$this->returnValue, $this->op1, $this->op2] = $c_args;

            $result = ($this->userHandler)($this);
            Zval::init_value($this->returnValue)->change_value($result);

            return \ZE::SUCCESS;
        }

        [$this->op1, $this->op2] = $c_args;

        $result = ($this->userHandler)($this);

        return $result;
    }

    /**
     * Proceeds with object comparison
     */
    public function continue()
    {
        if (!$this->has_original()) {
            throw new \LogicException('Original handler is not available');
        }

        if (\IS_PHP74)
            $result = ($this->originalHandler)($this->returnValue, $this->op1, $this->op2);
        else
            $result = ($this->originalHandler)($this->op1, $this->op2);

        return $result;
    }
}
