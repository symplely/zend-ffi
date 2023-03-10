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
    /*
static void php_thread_executor_globals_reinit(zend_executor_globals *dest,
		zend_executor_globals *src)
{
	dest->current_module = src->current_module;
}
*/

    /*
static void php_thread_compiler_globals_reinit(zend_compiler_globals *dest,
		zend_compiler_globals *src)
{
	zend_hash_clean(dest->function_table);
	zend_hash_copy(dest->function_table, src->function_table,
			(copy_ctor_func_t)function_add_ref, NULL,
			sizeof(zend_function));
	zend_hash_clean(dest->class_table);
	zend_hash_copy(dest->class_table, src->class_table,
			(copy_ctor_func_t)zend_class_add_ref, NULL,
			sizeof(zend_class_entry*));
}
*/
    function thread_startup($runtime) //: Thread
    {
        \ze_ffi()->ts_resource_ex(0, null);

        if (\IS_WINDOWS) {
            \tsrmls_cache_update();
            \zend_pg('com_initialized', 0);
        }

        \zend_pg('in_error_log', 0);

        \ze_ffi()->php_output_activate();

        \zend_pg('modules_activated', 0);
        \zend_pg('header_is_being_sent', 0);
        \zend_pg('connection_status', 0);
        \zend_pg('in_user_include', 0);

        //\ze_ffi()->php_request_startup();

        //    \zend_sg('server_context', $runtime()->parent->server);

        \zend_pg('expose_php', 0);
        \zend_pg('auto_globals_jit', 1);
        if (\PHP_VERSION_ID >= 80100)
            \zend_pg('enable_dl', true);
        else
            \zend_pg('enable_dl', 1);

        \zend_pg('during_request_startup', 0);
        \zend_sg('sapi_started', 0);
        \zend_sg('headers_sent', 1);
        \zend_sg('request_info')->no_headers = 1;

        //  \ze_ffi()->tsrm_mutex_unlock($this->module_mutex);
        // return $runtime;
    }

    function thread_shutdown()
    {
        /* Flush all output buffers */
        \ze_ffi()->php_output_end_all();

        /* Shutdown output layer (send the set HTTP headers, cleanup output handlers, etc.) */
        \ze_ffi()->php_output_deactivate();

        /* SAPI related shutdown (free stuff) */
        \ze_ffi()->sapi_deactivate();

        //  \ze_ffi()->php_request_shutdown(null);
        //\zend_sg('server_context', NULL);

        \ze_ffi()->sapi_shutdown();
        \ze_ffi()->ts_free_thread();
    }

    function thread_func(CData $arg)
    {
        /** @var Thread|PThread */
        $thread = \thread_startup(\zval_native_cast('zval*', $arg));

        do {
            /*
                if (!$thread instanceof PThread) {
                    $status = $thread->wait();
                    if ($status != \ZE::SUCCESS) {
                        break;
                    }
                }*/

            while (!$thread->empty()) {
                $thread->execute();
            }
            //	pthread_mutex_lock($thread->counter_mutex);
            //        $thread->num_threads_working--;
            //	if (!$thread>num_threads_working) {
            //		pthread_cond_signal($thread->counter_all_idle);
            //	}
            //	pthread_mutex_unlock($thread->counter_mutex);
        } while (true);

        $exception = \zend_eg('exception');
        if (\is_cdata($exception))
            \ze_ffi()->zend_exception_error($exception, \E_ERROR);

        \thread_shutdown();

        return NULL;
    }

    /* Wait until all jobs have finished */
    function thread_wait(Thread $pool)
    {
        //  pthread_mutex_lock($thpool_p->thcount_lock);
        // while ($thpool_p->jobqueue->len || $thpool_p->num_threads_working) {
        //       pthread_cond_wait($thpool_p->threads_all_idle, $thpool_p->thcount_lock);
        //   }
        //    pthread_mutex_unlock($thpool_p->thcount_lock);
    }
}
