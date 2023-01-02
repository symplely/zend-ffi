<?php

declare(strict_types=1);

namespace ZE\Hook;

use ZE\Hook\UnsetProperty;

/**
 * Allows to intercept property unset and handle this
 */
interface UnsetPropertyInterface
{
    /**
     * Performs reading of object's field
     *
     * @param UnsetProperty $hook Instance of current hook
     */
    public static function __unset_var(UnsetProperty $hook): void;
}
