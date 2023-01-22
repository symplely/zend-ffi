<?php

declare(strict_types=1);

namespace ZE\Hook;

use ZE\ObjectHandler;

/**
 * Receiving hook for performing operation on object
 */
class DoOperation extends ObjectHandler
{
    protected const HOOK_FIELD = 'do_operation';

    /**
     * Invoke user handler.
     * For PHP 7.4:
     *
     * typedef `int` (*zend_object_do_operation_t)(zend_uchar opcode, zval *result, zval *op1, zval *op2);
     *
     * For PHP 8+:
     *
     * typedef `int` (*zend_object_do_operation_t)(zend_uchar opcode, zval *result, zval *op1, zval *op2);
     */
    public function handle(...$c_args): int
    {
        [$this->opCode, $this->returnValue, $this->op1, $this->op2] = $c_args;

        $result = ($this->userHandler)($this);
        \zend_value($this->returnValue)->change_value($result);

        return \ZE::SUCCESS;
    }

    /**
     * Execute `original` handler with object custom operations
     */
    public function continue()
    {
        if (!$this->has_original()) {
            throw new \LogicException('Original handler is not available');
        }
        $result = ($this->originalHandler)($this->opCode, $this->returnValue, $this->op1, $this->op2);

        return $result;
    }
}
