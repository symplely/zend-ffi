<?php

declare(strict_types=1);

use FFI\CData;
use ZE\HashTable;
use ZE\PThread;
use ZE\Zval;
use ZE\Thread;
use ZE\ZendString;

if (\PHP_ZTS && !\class_exists('ThreadsModule')) {
    final class ThreadsModule extends \StandardModule
    {
        protected string $ffi_tag = 'ze';
        protected string $module_version = \PHP_VERSION;
        protected ?string $global_type = 'zend_server_context';

        protected bool $m_startup = true;
        protected bool $m_shutdown = true;
        protected bool $r_startup = true;
        protected bool $r_shutdown = true;

        protected ?\Closure $r_init = null;
        protected ?\Closure $r_end = null;
        protected ?\Closure $m_init = null;
        protected ?\Closure $m_end = null;
        protected ?\Closure $g_init = null;
        protected ?\Closure $g_end = null;

        const MODULES_TO_RELOAD = ['filter', 'session'];

        final public function thread_startup($runtime) //: Thread
        {
            // \ze_ffi()->tsrm_mutex_lock($this->module_mutex);

            \ze_ffi()->ts_resource_ex(0, null);
            if (\IS_WINDOWS) {
                \tsrmls_cache_update();
                \zend_pg('com_initialized', 0);
            }

            try {
                //code...
                //  \ze_ffi()->zend_deactivate();
                \zend_pg('in_error_log', 0);
                \zend_pg('during_request_startup', 1);

                \ze_ffi()->php_output_activate();

                /* initialize global variables */
                //  \zend_pg('modules_activated', 0);
                \zend_pg('header_is_being_sent', 0);
                \zend_pg('connection_status', 0);
                \zend_pg('in_user_include', 0);
                //  \ze_ffi()->zend_activate();
                //\ze_ffi()->sapi_activate();
            } catch (\Throwable $th) {
                throw $th;
            }

            //\ze_ffi()->sapi_startup(\ffi_ptr(\ze_ffi()->sapi_module));
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

            // return $runtime;
        }

        final public function thread_shutdown()
        {
            /* Flush all output buffers */
            // \ze_ffi()->php_output_end_all();
            /*
            // TODO: store the list of modules to reload in a global module variable
            foreach (self::MODULES_TO_RELOAD as $module_name) {
                $module = \zend_hash_str_find_ptr(HashTable::module_registry(), $module_name);
                ($module->request_shutdown_func)($module->type, $module->module_number);
            }*/

            /* Shutdown output layer (send the set HTTP headers, cleanup output handlers, etc.) */
            //\ze_ffi()->php_output_deactivate();

            /* SAPI related shutdown (free stuff) */
            // \ze_ffi()->sapi_deactivate();

            \ze_ffi()->php_request_shutdown(null);
            //\zend_sg('server_context', NULL);

            //   \ze_ffi()->sapi_shutdown();
            \ze_ffi()->ts_free_thread();
        }

        final public function thread_func(CData $arg)
        {
            /** @var Thread|PThread */
            $thread = $this->thread_startup(\zval_native_cast('zval*', $arg));

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

            $this->thread_shutdown();

            return NULL;
        }

        /* Wait until all jobs have finished */
        final public function thread_wait(Thread $pool)
        {
            //  pthread_mutex_lock($thpool_p->thcount_lock);
            // while ($thpool_p->jobqueue->len || $thpool_p->num_threads_working) {
            //       pthread_cond_wait($thpool_p->threads_all_idle, $thpool_p->thcount_lock);
            //   }
            //    pthread_mutex_unlock($thpool_p->thcount_lock);
        }

        public function set_global(string $typedef, string $ffi_tag = 'ze')
        {
            $this->ffi_tag = $ffi_tag;
            $this->global_type = $typedef;
        }

        public function set_lifecycle(
            callable $m_init = null,
            callable $m_end = null,
            callable $r_init = null,
            callable $r_end = null,
            callable $g_init = null,
            callable $g_end = null
        ): self {
            if (!\is_null($m_init))
                $this->m_init = $m_init;

            if (!\is_null($m_end))
                $this->m_end = $m_end;

            if (!\is_null($r_init))
                $this->r_init = $r_init;

            if (!\is_null($r_end))
                $this->r_end = $r_end;

            if (!\is_null($g_init))
                $this->g_init = $g_init;

            if (!\is_null($g_end))
                $this->g_end = $g_end;

            return $this;
        }

        public function startup(): void
        {
            $module = $this->ze_other_ptr;
            if ($this->r_startup) {
                $sapi_activate = $this->original_sapi_activate;
                \ze_ffi()->sapi_module->activate = function (...$args) use ($sapi_activate, $module) {
                    $result = ($module->request_startup_func)($module->type, $module->module_number);
                    $sapi_result = !\is_null($sapi_activate) ? $sapi_activate(...$args) : \ZE::SUCCESS;

                    return $result == $sapi_result && $result === \ZE::SUCCESS
                        ? \ZE::SUCCESS : \ZE::FAILURE;
                };
            }

            if ($this->r_shutdown) {
                $sapi_deactivate = $this->original_sapi_deactivate;
                \ze_ffi()->sapi_module->deactivate = function (...$args) use ($sapi_deactivate, $module) {
                    $result = ($module->request_shutdown_func)($module->type, $module->module_number);
                    $sapi_result = !\is_null($sapi_deactivate) ? $sapi_deactivate(...$args) : \ZE::SUCCESS;

                    return $result == $sapi_result && $result === \ZE::SUCCESS
                        ? \ZE::SUCCESS : \ZE::FAILURE;
                };
            }

            if (\PHP_ZTS)
                \ze_ffi()->sapi_module->ub_write = $this->module_sapi_output;

            if (\ze_ffi()->zend_startup_module_ex($module) !== \ZE::SUCCESS) {
                throw new \RuntimeException('Can not startup module ' . $this->module_name);
            }

            if ($this->r_shutdown)
                \register_shutdown_function(
                    \closure_from($this, 'module_destructor')
                );

            \ze_ffi()->php_output_activate();
            if (
                \ze_ffi()->php_module_startup(\FFI::addr(\ze_ffi()->sapi_module), null, 0)
                !== \ZE::SUCCESS
            ) {
                throw new \RuntimeException(
                    'Can not restart SAPI module ' . \ffi_string(\ze_ffi()->sapi_module->name)
                );
            }
        }

        public function module_startup(int $type, int $module_number): int
        {
            \ze_ffi()->php_output_end_all();
            \ze_ffi()->php_output_deactivate();
            \ze_ffi()->php_output_shutdown();
            \ze_ffi()->sapi_flush();
            // \ze_ffi()->sapi_deactivate();
            \ze_ffi()->sapi_shutdown();
            return !\is_null($this->m_init)
                ? ($this->m_init)($type, $module_number) : \ZE::SUCCESS;
        }

        public function module_shutdown(int $type, int $module_number): int
        {
            return !\is_null($this->m_end)
                ? ($this->m_end)($type, $module_number) : \ZE::SUCCESS;
        }

        public function request_startup(...$args): int
        {
            // $this->thread_startup(...$args);
            return !\is_null($this->r_init)
                ? ($this->r_init)(...$args) : \ZE::SUCCESS;
        }

        public function request_shutdown(...$args): int
        {
            // $this->thread_shutdown();
            return !\is_null($this->r_end)
                ? ($this->r_end)(...$args) : \ZE::SUCCESS;
        }

        public function global_startup(CData $memory): void
        {
            if (\PHP_ZTS) {
                \tsrmls_activate();
                $id = \ze_ffi()->tsrm_thread_id();
                if (!isset($this->global_id[$id])) {
                    $this->global_rsrc[$id] = \c_int_type('ts_rsrc_id', 'ze', null, false, $this->target_persistent);
                    $this->global_id[$id] = \ze_ffi()->ts_allocate_id(
                        $this->global_rsrc[$id]->addr(),
                        $this->globals_size(),
                        null,
                        null
                    );
                }
            }

            if (!\is_null($this->g_init)) ($this->g_init)($memory);
        }

        /**
         * Represents `PHP_GSHUTDOWN_FUNCTION()` _macro_.
         *
         * @param CData $memory `void*` needs to be __cast__ to `global_type()`
         * @return void
         */
        public function global_shutdown(CData $memory): void
        {
            if (!\is_null($this->g_end)) ($this->g_end)($memory);

            $this->__destruct();
        }
    }
}
