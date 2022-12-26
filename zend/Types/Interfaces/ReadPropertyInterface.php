<?php

declare(strict_types=1);

namespace ZE\Hook;

use ZE\Hook\ReadProperty;

/**
 * Allows to intercept property reads and modify values
 */
interface ReadPropertyInterface
{
    /**
     * Performs reading of object's field
     *
     * @param ReadProperty $hook Instance of current hook
     *
     * @return mixed Value to return
     */
    public static function __reader(ReadProperty $hook);
}
