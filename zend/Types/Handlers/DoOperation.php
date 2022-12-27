<?php

declare(strict_types=1);

namespace ZE\Hook;

use ZE\Zval;
use ZE\ObjectHandler;

/**
 * Receiving hook for performing operation on object
 */
class DoOperation extends ObjectHandler
{
    protected const HOOK_FIELD = 'do_operation';

    /**
     * typedef `int` (*zend_object_do_operation_t)(zend_uchar opcode, zval *result, zval *op1, zval *op2);
     *
     * @inheritDoc
     */
    public function handle(...$c_args): int
    {
        [$this->opCode, $this->returnValue, $this->op1, $this->op2] = $c_args;

        $result = ($this->userHandler)($this);
        Zval::init_value($this->returnValue)->native_value($result);

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
