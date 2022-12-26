<?php

declare(strict_types=1);

namespace ZE\Hook;

use ZE\Hook\CompareValues;

/**
 * Allows to perform comparison of objects
 */
interface CompareValuesInterface
{
    /**
     * Performs comparison of given object with another value
     *
     * @param CompareValues $hook Instance of current hook
     *
     * @return int Result of comparison: 1 is greater, -1 is less, 0 is equal
     */
    public static function __compare(CompareValues $hook): int;
}
