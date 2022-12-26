<?php

declare(strict_types=1);

namespace ZE\Hook;

use ZE\Hook\DoOperation;

/**
 * Allows to perform math operations (aka operator overloading) on object
 */
interface DoOperationInterface
{
    /**
     * Performs an operation on given object
     *
     * @param DoOperation $hook Instance of current hook
     *
     * @return mixed Result of operation value
     */
    public static function __math(DoOperation $hook);
}
