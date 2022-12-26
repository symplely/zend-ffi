<?php

declare(strict_types=1);

namespace ZE\Hook;

use FFI\CData;
use ZE\Hook\CreateObject;

/**
 * Allows to hook into the object initialization process (eg new FooBar())
 */
interface CreateInterface
{
    /**
     * Performs low-level initialization of object during new instances creation
     *
     * @param CreateObject $hook Hook instance that provides proceed() and class_type() method
     *
     * @return CData Pointer to the zend_object instance
     */
    public static function __init(CreateObject $hook): CData;
}
