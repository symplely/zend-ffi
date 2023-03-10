<?php

declare(strict_types=1);

use FFI\CData;

if (\PHP_ZTS && !\class_exists('ThreadsModule')) {
    final class ThreadsModule extends \StandardModule
    {
        const THREADS_READY     = (1 << 0);
        const THREADS_EXEC      = (1 << 1);
        const THREADS_CLOSE     = (1 << 2);
        const THREADS_CLOSED    = (1 << 3);
        const THREADS_KILLED    = (1 << 4);
        const THREADS_ERROR     = (1 << 5);
        const THREADS_DONE      = (1 << 6);
        const THREADS_CANCELLED = (1 << 7);
        const THREADS_RUNNING   = (1 << 8);
        const THREADS_FAILURE   = (1 << 12);

        protected string $ffi_tag = 'ts';
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

        /** @var \Closure */
        protected ?CData $original_sapi_output = null;

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
            \ze_ffi()->php_output_shutdown();

            \ze_ffi()->sapi_flush();
            \ze_ffi()->sapi_deactivate();
            \ze_ffi()->sapi_shutdown();

            if ($this->r_startup) {
                \ze_ffi()->sapi_module->activate = function (...$args) use ($module) {
                    $result = ($module->request_startup_func)($module->type, $module->module_number);
                    $sapi_result = !\is_null($this->original_sapi_activate) ? ($this->original_sapi_activate)(...$args) : \ZE::SUCCESS;

                    return ($result == $sapi_result && $result === \ZE::SUCCESS)
                        ? \ZE::SUCCESS : \ZE::FAILURE;
                };
            }

            if ($this->r_shutdown) {
                \ze_ffi()->sapi_module->deactivate = function (...$args) use ($module) {
                    $result = ($module->request_shutdown_func)($module->type, $module->module_number);
                    $sapi_result = !\is_null($this->original_sapi_deactivate) ? ($this->original_sapi_deactivate)(...$args) : \ZE::SUCCESS;

                    return ($result == $sapi_result && $result === \ZE::SUCCESS)
                        ? \ZE::SUCCESS : \ZE::FAILURE;
                };
            }

            $this->original_sapi_output = \ze_ffi()->sapi_module->ub_write;
            \ze_ffi()->sapi_module->ub_write = function (string $str, int $len): int {
                $mutex = \Core::get_mutex();
                if (!\is_cdata($mutex)) {
                    $mutex =  \Core::reset_mutex();
                }

                \ze_ffi()->tsrm_mutex_lock($mutex);
                $result = ($this->original_sapi_output)($str, $len);
                \ze_ffi()->tsrm_mutex_unlock($mutex);

                return $result;
            };

            if (\ze_ffi()->zend_startup_module_ex($module) !== \ZE::SUCCESS) {
                throw new \RuntimeException('Can not startup module ' . $this->module_name);
            }

            if ($this->r_shutdown)
                \register_shutdown_function(
                    \closure_from($this, 'module_destructor')
                );

            $result = \IS_PHP82
                ? \ze_ffi()->php_module_startup(\FFI::addr(\ze_ffi()->sapi_module), null)
                : \ze_ffi()->php_module_startup(\FFI::addr(\ze_ffi()->sapi_module), null, 0);
            if ($result !== \ZE::SUCCESS) {
                throw new \RuntimeException(
                    'Can not restart SAPI module ' . \ffi_string(\ze_ffi()->sapi_module->name)
                );
            }
        }

        public function module_startup(int $type, int $module_number): int
        {
            return !\is_null($this->m_init)
                ? ($this->m_init)($type, $module_number) : \ZE::SUCCESS;
        }

        public function module_shutdown(int $type, int $module_number): int
        {
            return !\is_null($this->m_end)
                ? ($this->m_end)($type, $module_number) : \ZE::SUCCESS;
        }

        public function request_startup(int $type, int $module_number): int
        {
            return !\is_null($this->r_init)
                ? ($this->r_init)($type, $module_number) : \ZE::SUCCESS;
        }

        public function request_shutdown(int $type, int $module_number): int
        {
            return !\is_null($this->r_end)
                ? ($this->r_end)($type, $module_number) : \ZE::SUCCESS;
        }

        public function global_startup(CData $memory): void
        {
            if (!\is_null($this->g_init)) ($this->g_init)($memory);
        }

        public function global_shutdown(CData $memory): void
        {
            if (!\is_null($this->g_end)) ($this->g_end)($memory);

            if (!$this->target_persistent) {
                if (\is_ze_ffi()) {
                    \ze_ffi()->sapi_module->ub_write = $this->original_sapi_output;
                    $this->original_sapi_output = null;
                }
            }
        }
    }
}
