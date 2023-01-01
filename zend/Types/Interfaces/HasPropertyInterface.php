<?php

declare(strict_types=1);

namespace ZE\Hook;

use ZE\Hook\HasProperty;

/**
 * Allows to intercept property isset/has checks
 */
interface ObjectHasPropertyInterface
{
    /**
     * Performs checking of object's field
     *
     * @param HasProperty $hook Instance of current hook
     *
     * @return int Value to return
     */
    public static function __fieldIsset(HasProperty $hook);
}