<?php

declare(strict_types=1);

namespace ZE\Hook;

use ZE\Zval;
use ZE\ObjectHandler;

/**
 * For casting object to another type
 */
class CastObject extends ObjectHandler
{
    protected const HOOK_FIELD = 'cast_object';

    /**
     * Invoke user handler.
     * For PHP 7.4:
     *
     * typedef `int` (*zend_object_cast_t)(zval *readobj, zval *retval, int type);
     *
     * For PHP 8+:
     *
     * typedef `int` (*zend_object_cast_t)(zend_object *readobj, zval *retval, int type);
     */
    public function handle(...$c_args): int
    {
        [$this->object, $this->returnValue, $this->type] = $c_args;

        $result = ($this->userHandler)($this);
        Zval::init_value($this->returnValue)->change_value($result);

        return \ZE::SUCCESS;
    }

    /**
     * Returns the cast type, a constant type `\ZE:IS_**`
     */
    public function cast_type(): int
    {
        return $this->type;
    }

    /**
     * Proceeds with object casting
     */
    public function continue()
    {
        if (!$this->has_original()) {
            throw new \LogicException('Original handler is not available');
        }

        $result = ($this->originalHandler)($this->object, $this->returnValue, $this->type);

        return $result;
    }
}
