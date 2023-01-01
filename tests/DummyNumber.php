<?php

declare(strict_types=1);

namespace Tests;

use FFI\CData;
use ZE\Zval;
use ZE\OpCode;
use ZE\Hook\CastObject;
use ZE\Hook\CreateObject;
use ZE\Hook\CompareValues;
use ZE\Hook\DoOperation;
use ZE\Hook\CastInterface;
use ZE\Hook\CompareValuesInterface;
use ZE\Hook\CreateInterface;
use ZE\Hook\DoOperationInterface;

class DummyNumber implements
    CreateInterface,
    CompareValuesInterface,
    DoOperationInterface,
    CastInterface
{
    private $value;

    public function __construct($value)
    {
        if (!is_numeric($value)) {
            throw new \InvalidArgumentException('Only numeric values are allowed');
        }
        $this->value = $value;
    }

    public static function __init(CreateObject $hook): CData
    {
        return $hook->continue();
    }

    /**
     * @param NativeNumber $instance
     * @inheritDoc
     */
    public static function __cast(CastObject $hook)
    {
        $typeTo = $hook->cast_type();
        switch ($typeTo) {
            case Zval::_IS_NUMBER:
            case Zval::IS_LONG:
                return (int) $hook->object()->value;
            case Zval::IS_DOUBLE:
                return (float) $hook->object()->value;
        }

        throw new \UnexpectedValueException('Can not cast number to the ' . Zval::name($typeTo));
    }

    /**
     * Performs comparison of given object with another value
     *
     * @param CompareValues $hook Instance of current hook
     *
     * @return int Result of comparison: 1 is greater, -1 is less, 0 is equal
     */
    public static function __compare(CompareValues $hook): int
    {
        $left  = self::getNumericValue($hook->op1());
        $right = self::getNumericValue($hook->op2());

        return $left <=> $right;
    }

    /**
     * @inheritDoc
     */
    public static function __math(DoOperation $hook)
    {
        $opCode = $hook->opcode();
        $left   = self::getNumericValue($hook->op1());
        $right  = self::getNumericValue($hook->op2());
        switch ($opCode) {
            case OpCode::ADD:
                $result = $left + $right;
                break;
            case OpCode::SUB:
                $result = $left - $right;
                break;
            case OpCode::MUL:
                $result = $left * $right;
                break;
            case OpCode::DIV:
                $result = $left / $right;
                break;
            default:
                throw new \UnexpectedValueException("Opcode " . OpCode::name($opCode) . " wasn't held.");
        }

        return new static($result);
    }

    /**
     * @param $one
     *
     * @return int|string
     */
    private static function getNumericValue($one)
    {
        if ($one instanceof DummyNumber) {
            $left = $one->value;
        } elseif (is_numeric($one)) {
            $left = $one;
        } else {
            throw new \UnexpectedValueException('DummyNumber can be compared only with numeric values and itself');
        }

        return $left;
    }
}
