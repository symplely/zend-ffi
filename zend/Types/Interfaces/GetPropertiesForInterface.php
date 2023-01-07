<?php

declare(strict_types=1);

namespace ZE\Hook;

use ZE\Hook\GetPropertiesFor;

/**
 * Allows to intercept casting to arrays, debug queries for object, etc
 */
interface GetPropertiesForInterface
{
    /**
     * Returns a hash-map (array) representation of object (for casting to array, json encoding, var dumping)
     *
     * @param GetPropertiesFor $hook Instance of current hook
     *
     * @return array Key-value pair of fields
     */
    public static function __get_vars(GetPropertiesFor $hook): array;
}
