<?php

declare(strict_types=1);

namespace ZE\Hook;

use ZE\Hook\GetPropertyPointer;

/**
 * Allows to intercept creation of pointers to properties (indirect changes)
 */
interface GetPropertyPointerInterface
{
    /**
     * Returns a pointer to an object's field
     *
     * @param GetPropertyPointer $hook Instance of current hook
     *
     * @return mixed Value to return
     */
    public static function __pointer(GetPropertyPointer $hook);
}
