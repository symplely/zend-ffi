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
            $module = new \ThreadsModule(null, \ZEND_THREAD_SAFE, \ZEND_DEBUG_BUILD, \ZEND_MODULE_API_NO, false);
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
            'Thread customization not possible, registration has already finished!'
        );
    }

    function threads_activate(): \ThreadsModule
    {
        $module = \threads_get_module();
        if (\is_null($module)) {
            $module = new \ThreadsModule();
        }

        return $module;
    }

    function thread_init(PThread $instance = null): Thread
    {
        $module = \threads_get_module();
        if (\is_null($module)) {
            $module = \threads_activate();
        }

        if (\is_null($instance))
            $instance = new PThread($module);

        return new Thread($module, $instance);
    }

    function pthread_init(): PThread
    {
        $module = \threads_get_module();
        if (\is_null($module)) {
            $module = \threads_activate();
        }

        return new PThread($module);
    }

    function tsrmls_cache_define(): void
    {
        if (\PHP_ZTS) {
            global $_tsrm_ls_cache;
            $_tsrm_ls_cache[\ze_ffi()->tsrm_thread_id()] = null;
        }
    }

    function tsrmls_cache_update(): void
    {
        if (\PHP_ZTS) {
            global $_tsrm_ls_cache;
            $_tsrm_ls_cache[\ze_ffi()->tsrm_thread_id()] = \ze_ffi()->tsrm_get_ls_cache();
        }
    }

    function tsrmls_cache(): ?CData
    {
        if (\PHP_ZTS) {
            global $_tsrm_ls_cache;
            return $_tsrm_ls_cache[\ze_ffi()->tsrm_thread_id()];
        }

        return null;
    }

    function tsrmls_activate(): void
    {
        if (\PHP_ZTS) {
            \ze_ffi()->ts_resource_ex(0, null);
            \tsrmls_cache_update();
        }
    }

    function tsrmls_deactivate(): void
    {
        if (\PHP_ZTS) {
            \ze_ffi()->ts_free_id(0);
            \tsrmls_cache_define();
        }
    }

    function thread_startup(Thread $runtime): Thread
    {/*
        $tsrm_ls = \ze_ffi()->tsrm_new_interpreter_context();
        $old = \ze_ffi()->tsrm_set_interpreter_context($tsrm_ls);
        $runtime->set_contexts($tsrm_ls, $old);

        \zend_pg('expose_php', 0);
        \zend_pg('auto_globals_jit', 0);

        \ze_ffi()->php_request_startup();

        \zend_eg('current_execute_data', NULL);
        \zend_eg('current_module', $runtime->get_module()());
        */
        \ze_ffi()->ts_resource_ex(0, null);

        \tsrmls_cache_update();
        if (\IS_WINDOWS) {
            \zend_pg('com_initialized', 0);
        }

        \zend_sg('server_context', $runtime()->parent->server);
        $runtime()->child->interrupt = \ffi_ptr(\zend_eg('vm_interrupt'));

        \zend_pg('expose_php', 0);
        \zend_pg('auto_globals_jit', 1);
        if (\PHP_VERSION_ID >= 80100)
            \zend_pg('enable_dl', true);
        else
            \zend_pg('enable_dl', 1);

        \standard_activate($runtime->get_module());

        \zend_pg('during_request_startup', 0);
        \zend_sg('sapi_started', 0);
        \zend_sg('headers_sent', 1);
        \zend_sg('request_info')->no_headers = 1;

        return $runtime;
    }

    function thread_shutdown(Thread $runtime)
    {/*
        [$tsrm_ls, $old] = $runtime->get_contexts();

        \ze_ffi()->php_request_shutdown(NULL);
        \ze_ffi()->tsrm_set_interpreter_context($old);
        \ze_ffi()->tsrm_free_interpreter_context($tsrm_ls);
        */
        \ze_ffi()->php_output_shutdown();

        \standard_deactivate($runtime->get_module());

        \ze_ffi()->ts_free_thread();

        \ts_ffi()->pthread_exit(\ffi_null());
    }
}
