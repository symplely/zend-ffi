<?php

declare(strict_types=1);

use FFI\CData;
use ZE\PThread;
use ZE\Thread;

if (\PHP_ZTS && !\function_exists('pthread_init')) {
    function threads_get_module(): ?\ThreadsModule
    {
        return \ThreadsModule::get_module();
    }

    function threads_customize(
        callable $module_startup = null,
        callable $module_shutdown = null,
        callable $request_startup = null,
        callable $request_shutdown = null,
        callable $global_startup = null,
        callable $global_shutdown = null
    ): \ThreadsModule {
        $module = \threads_get_module();
        if (\is_null($module)) {
            $module = new \ThreadsModule();
            $module->set_lifecycle(
                $module_startup,
                $module_shutdown,
                $request_startup,
                $request_shutdown,
                $global_startup,
                $global_shutdown
            );
            $module->register();
            $module->startup();

            return $module;
        }

        return \ze_ffi()->zend_error(
            \E_WARNING,
            'Thread customization not possible, registration has already finish!'
        );
    }

    function threads_activate(): \ThreadsModule
    {
        $module = \threads_get_module();
        if (\is_null($module)) {
            $module = new \ThreadsModule();
            $module->register();
            $module->startup();
        }

        return $module;
    }

    function thread_init(): Thread
    {
        $module = \threads_get_module();
        if (\is_null($module)) {
            $module = \threads_activate();
        }

        return new Thread($module);
    }

    function pthread_init(): PThread
    {
        $module = \threads_get_module();
        if (\is_null($module)) {
            $module = \threads_activate();
        }

        return new PThread($module);
    }
}
