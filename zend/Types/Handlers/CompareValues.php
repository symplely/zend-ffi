<?php

declare(strict_types=1);

namespace ZE\Hook;

use ZE\ObjectHandler;

/**
 * Receiving hook for performing operation on object
 */
class CompareValues extends ObjectHandler
{
    protected const HOOK_FIELD = 'compare';

    /**
     * typedef `int` (*zend_object_compare_t)(zval *object1, zval *object2);
     *
     * @inheritDoc
     */
    public function handle(...$c_args): int
    {
        [$this->op1, $this->op2] = $c_args;

        $result = ($this->userHandler)($this->op1, $this->op2);

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
        $result = ($this->originalHandler)($this->op1, $this->op2);

        return $result;
    }
}
