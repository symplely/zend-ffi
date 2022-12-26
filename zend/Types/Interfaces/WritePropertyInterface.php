<?php

declare(strict_types=1);

namespace ZE\Hook;

use ZE\Hook\WriteProperty;

/**
 * Allows to intercept property writes and modify values
 */
interface WritePropertyInterface
{
    /**
     * Performs writing of value to object's field
     *
     * @param WriteProperty $hook Instance of current hook
     *
     * @return mixed New value to write, return given $value if you don't want to adjust it
     */
    public static function __writer(WriteProperty $hook);
}
