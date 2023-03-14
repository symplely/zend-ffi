<?php

declare(strict_types=1);

use FFI\CData;
use ZE\Zval;
use ZE\ZendModule;

if (!\class_exists('StandardModule')) {
    /**
     * An `FFI` _abstract_ class to **extend** that contains _general logic_ methods for **extension** `registration` and `startup`.
     * - Represents `STANDARD_MODULE` macro of the PHP lifecycle:
     * https://www.phpinternalsbook.com/php7/extensions_design/php_lifecycle.html
     *
     * _The following property MUST be declared:_
     *```php
     * // An `FFI` instance tag *name*
     * protected string $ffi_tag = 'instance';
     *
     * // If not set, class name will be used as module name
     * protected string $module_name = 'extension name';
     *
     * // Version number of this module
     * protected string $module_version = '0.0.0';
     *
     * // Represents `ZEND_DECLARE_MODULE_GLOBALS` _macro_.
     * protected ?string $global_type = null;
     *
     * // Do? PHP_MINIT_FUNCTION().
     * protected bool $m_startup = false;
     *
     * // Do? PHP_MSHUTDOWN_FUNCTION().
     * protected bool $m_shutdown = false;
     *
     * // Do? PHP_RINIT_FUNCTION().
     * protected bool $r_startup = false;
     *
     * // Do? PHP_RSHUTDOWN_FUNCTION().
     * protected bool $r_shutdown = false;
     *
     * // Do? PHP_GINIT_FUNCTION().
     * protected bool $g_startup = false;
     *
     * // Do? PHP_GSHUTDOWN_FUNCTION().
     * protected bool $g_shutdown = false;
     *```
     *
     * _The following methods SHOULD ONLY be declared if the **above** corresponding property have been set `true`:_
     *```php
     * // Represents `PHP_MINIT_FUNCTION()` _macro_.
     * public function module_startup(int $type, int $module_number): int
     *
     * // Represents `PHP_MSHUTDOWN_FUNCTION()` _macro_.
     * public function module_shutdown(int $type, int $module_number): int
     *
     * // Represents `PHP_RINIT_FUNCTION()` _macro_.
     * public function request_startup(int $type, int $module_number): int
     *
     * // Represents `PHP_RSHUTDOWN_FUNCTION()` _macro_.
     * public function request_shutdown(int $type, int $module_number): int
     *```
     *
     * _The following methods WILL be executed regardless, if the `$global_type` property is set:_
     *```php
     * // Represents `PHP_GINIT_FUNCTION()` _macro_.
     * public function global_startup(\FFI\CData $memory): void
     *
     * // Represents `PHP_GSHUTDOWN_FUNCTION()` _macro_.
     * public function global_shutdown(\FFI\CData $memory): void
     *```
     *
     * _The following method WILL be executed for `phpinfo()`:_
     *```php
     * // Represents `PHP_MINFO_FUNCTION()` _macro_.
     * public function module_info(\FFI\CData $entry): void
     *```
     */
    abstract class StandardModule extends ZendModule
    {
        /**
         * `ZTS|NTS` _ts_rsrc_id_ or _C typedef_ **instance**
         * @var \CStruct[]
         */
        protected $global_rsrc = [];

        /**
         * `ZTS` _ts_rsrc_id_
         */
        protected array $global_id = [];

        /**
         * Set true if this module should be persistent or false if temporary
         */
        protected bool $target_persistent = false;

        /**
         * Sets the target thread-safe mode for this module
         *
         * Use ZEND_THREAD_SAFE as default if your module does not depend on thread-safe mode.
         */
        protected bool $target_threads = \ZEND_THREAD_SAFE;

        /**
         * Sets the target debug mode for this module
         *
         * Use ZEND_DEBUG_BUILD as default if your module does not depend on debug mode.
         */
        protected bool $target_debug = \ZEND_DEBUG_BUILD;

        /**
         * Sets the target API version for this module
         *
         * @see zend_modules.h:ZEND_MODULE_API_NO
         */
        protected int $target_version = \ZEND_MODULE_API_NO;

        /**
         * An `FFI` instance tag *name*
         */
        protected string $ffi_tag;

        /**
         * Unique name of this module
         * - If not set, class name will be used as module name
         */
        protected string $module_name;

        /**
         * Version number of this module
         */
        protected string $module_version;

        /**
         * Sets global type (if present) or null if module doesn't use global memory.
         * - Represents `ZEND_DECLARE_MODULE_GLOBALS` _macro_.
         */
        protected ?string $global_type = null;

        /** Do module startup? */
        protected bool $m_startup = false;

        /** Do module shutdown? */
        protected bool $m_shutdown = false;

        /** Do request startup? */
        protected bool $r_startup = false;

        /** Do request shutdown? */
        protected bool $r_shutdown = false;

        /** Do global startup? */
        protected bool $g_startup = false;

        /** Do global shutdown? */
        protected bool $g_shutdown = false;

        protected bool $restart_sapi = true;

        protected bool $destructor_linked = false;

        protected static $global_module;

        /** @var \Closure */
        protected ?CData $original_sapi_activate = null;

        /** @var \Closure */
        protected ?CData $original_sapi_deactivate = null;

        /** @var \MUTEX_T */
        protected ?CData $module_mutex = null;

        final public function destructor_set(): void
        {
            $this->destructor_linked = true;
        }

        final public function is_sapi(): bool
        {
            return $this->restart_sapi;
        }

        /**
         * Executes `request_shutdown()`, and if __destruct_on_request__ is `true`, _module_shutdown()_ and _global_shutdown()_.
         *
         * @return void
         */
        final public function module_destructor(): void
        {
            $module = $this->__invoke();
            if ($this->r_shutdown && !\is_null($module))
                $this->request_shutdown($module->type, $module->module_number);

            if (!$this->target_persistent || !$this->restart_sapi) {
                if ($this->restart_sapi && $this->r_startup) {
                    \ze_ffi()->sapi_module->activate = $this->original_sapi_activate;
                    $this->original_sapi_activate = null;
                }

                if ($this->restart_sapi && $this->r_shutdown) {
                    \ze_ffi()->sapi_module->deactivate = $this->original_sapi_deactivate;
                    $this->original_sapi_deactivate = null;
                }

                if (\PHP_ZTS) {
                    $id = \ze_ffi()->tsrm_thread_id();
                    if (isset($this->global_id[$id])) {
                        \ze_ffi()->ts_free_id($this->global_id[$id]);
                        $this->global_id[$id] = null;
                        $this->global_rsrc[$id] = null;
                    }

                    \ze_ffi()->tsrm_mutex_free($this->module_mutex);
                    $this->module_mutex = null;
                } else {
                    $this->global_rsrc = null;
                }

                if (!$this->destructor_linked)
                    static::clear_module();
            }
        }

        final protected static function set_module(\StandardModule $module): void
        {
            if (\PHP_ZTS)
                self::$global_module[\ze_ffi()->tsrm_thread_id()] = $module;
            else
                self::$global_module[static::class] = $module;
        }

        /**
         * Force clear and shutdown module.
         * - Will cause `PHP_MSHUTDOWN_FUNCTION()` and `PHP_GSHUTDOWN_FUNCTION()` to execute.
         *
         * @return void
         */
        final public static function clear_module(): void
        {
            /** @var static */
            $module = (\PHP_ZTS)
                ? self::$global_module[\ze_ffi()->tsrm_thread_id()]
                : self::$global_module[static::class];

            if (!\is_null($module)) {
                if (\PHP_ZTS)
                    self::$global_module[\ze_ffi()->tsrm_thread_id()] = null;
                else
                    self::$global_module[static::class] = null;

                \zend_hash_delete($module->module_name);
                $module->ze_other_ptr = null;
                $module->ze_other = null;
                $module->reflection = null;
                \zval_del_ref($module);
            }
        }

        /**
         * Represents `ZEND_GET_MODULE()` _macro_.
         *
         * @return static|null
         */
        final public static function get_module(): ?self
        {
            if (\PHP_ZTS)
                return self::$global_module[\ze_ffi()->tsrm_thread_id()] ?? null;

            return self::$global_module[static::class];
        }

        /**
         * Returns module's `FFI` instance.
         *
         * @return \FFI
         */
        final public function ffi(): \FFI
        {
            return \Core::get($this->ffi_tag);
        }

        /**
         * Module constructor.
         *
         * @param boolean $restart_sapi if a `PHP_RINIT_FUNCTION` is provided, this will hook into current SAPI process.
         * - Default is `true`, the only way to get `request startup` callback to execute.
         * @param boolean $target_threads Use `ZEND_THREAD_SAFE` as default if your module does not depend on thread-safe mode.
         * - Set the thread-safe mode for this module.
         * @param boolean $target_debug Use `ZEND_DEBUG_BUILD` as default if your module does not depend on debug mode.
         * - Set the debug mode for this module.
         * @param int $target_version `ZEND_MODULE_API_NO`
         * - Set the API version for this module
         * @param boolean $registerAndStartup
         *
         * @return self
         */
        final public function __construct(
            bool $restart_sapi = null,
            bool $target_threads = \ZEND_THREAD_SAFE,
            bool $target_debug = \ZEND_DEBUG_BUILD,
            int $target_version = \ZEND_MODULE_API_NO,
            bool $registerAndStartup = true
        ) {
            if (!isset($this->ffi_tag))
                return \ze_ffi()->zend_error(\E_ERROR, 'No `FFI` instance found!');

            if (!isset($this->module_name))
                $this->module_name = self::detect_name();

            if (!\is_null($restart_sapi))
                $this->restart_sapi = $restart_sapi;

            $this->target_threads = $target_threads;
            $this->target_debug = $target_debug;
            $this->target_version = $target_version;

            // if module is already registered, then we can use it immediately
            if ($this->is_registered()) {
                /** @var Zval */
                $ext = \zend_hash_find($this->module_name);
                if ($ext === null) {
                    return \ze_ffi()->zend_error(\E_WARNING, "Module %s should be in the engine.", $this->module_name);
                }

                $ptr = $ext->ptr();
                $this->update(\ze_ffi()->cast('zend_module_entry*', $ptr));
                $this->addReflection($ptr->name);
            } elseif ($registerAndStartup) {
                $this->register();
                $this->startup();
            }

            if (\PHP_ZTS && \is_null($this->module_mutex))
                $this->module_mutex = \ze_ffi()->tsrm_mutex_alloc();
        }

        /**
         * Represents `PHP_MINIT_FUNCTION()` _macro_.
         *
         * @param integer $type
         * @param integer $module_number
         * @return integer
         */
        public function module_startup(int $type, int $module_number): int
        {
            return \ZE::SUCCESS;
        }

        /**
         * Represents `PHP_MSHUTDOWN_FUNCTION()` _macro_.
         *
         * @param integer $type
         * @param integer $module_number
         * @return integer
         */
        public function module_shutdown(int $type, int $module_number): int
        {
            return \ZE::SUCCESS;
        }

        /**
         * Represents `PHP_RINIT_FUNCTION()` _macro_.
         *
         * @param integer $type
         * @param integer $module_number
         * @return integer
         */
        public function request_startup(int $type, int $module_number): int
        {
            return \ZE::SUCCESS;
        }

        /**
         * Represents `PHP_RSHUTDOWN_FUNCTION()` _macro_.
         *
         * @param integer $type
         * @param integer $module_number
         * @return integer
         */
        public function request_shutdown(int $type, int $module_number): int
        {
            return \ZE::SUCCESS;
        }

        /**
         * Represents `PHP_GINIT_FUNCTION()` _macro_.
         *
         * @param CData|void_t $memory `void*` needs to be __cast__ to `global_type()`
         * @return void
         */
        public function global_startup(CData $memory): void
        {
        }

        /**
         * Represents `PHP_GSHUTDOWN_FUNCTION()` _macro_.
         *
         * @param CData|zend_module_entry $memory
         * @return void
         */
        public function global_shutdown(CData $memory): void
        {
        }

        /**
         * Represents `PHP_MINFO_FUNCTION()` _macro_.
         *
         * @param CData|zend_module_entry $entry
         * @return void
         */
        public function module_info(CData $entry): void
        {
            \ze_ffi()->php_info_print_table_start();
            \ze_ffi()->php_info_print_table_header(2, $entry->name . " support", "enabled");
            \ze_ffi()->php_info_print_table_row(2, $entry->name . " version", $entry->version);
            \ze_ffi()->php_info_print_table_end();
        }

        /**
         * Returns the unique name of this module.
         */
        final public static function get_name(): string
        {
            return static::get_module()->module_name;
        }

        /**
         * Checks if this module loaded or not.
         */
        final public function is_registered(): bool
        {
            return \extension_loaded($this->module_name);
        }

        /**
         * Performs registration of this module in the engine.
         */
        final public function register(): void
        {
            if ($this->is_registered()) {
                throw new \RuntimeException('Module ' . $this->module_name . ' was already registered.');
            }

            $this->target_persistent = \Core::is_scoped();

            // We don't need persistent memory here, as PHP copies structures into persistent memory itself
            $this->ze_other = \ze_ffi()->new('zend_module_entry', false);
            $moduleName = $this->module_name;
            $this->ze_other->size = \FFI::sizeof($this->ze_other);
            $this->ze_other->type = \MODULE_PERSISTENT;
            $this->ze_other->name = \ffi_char($moduleName, false, $this->target_persistent);
            $this->ze_other->zend_api = $this->target_version;
            $this->ze_other->zend_debug = (int)$this->target_debug;
            $this->ze_other->zts = (int)$this->target_threads;
            if (isset($this->module_version))
                $this->ze_other->version = \ffi_char($this->module_version, false, $this->target_persistent);

            $globalType = $this->global_type();
            if (!\is_null($globalType)) {
                if (\PHP_ZTS) {
                    \tsrmls_cache_define();
                    \tsrmls_activate();
                    $id = \ze_ffi()->tsrm_thread_id();
                    $this->global_rsrc[$id] = $this->ffi()->new('ts_rsrc_id', false, $this->target_persistent);
                    $this->ze_other->globals_id_ptr = \FFI::addr($this->global_rsrc[$id]);
                    $this->ze_other->globals_size = \FFI::sizeof($this->ffi()->type($globalType));
                    $this->global_id[$id] = \ze_ffi()->ts_allocate_id(
                        $this->ze_other->globals_id_ptr,
                        $this->ze_other->globals_size,
                        null,
                        null
                    );
                } else {
                    $this->global_rsrc = $this->ffi()->new($globalType, false, $this->target_persistent);
                    $this->ze_other->globals_ptr = \FFI::addr($this->global_rsrc);
                    $this->ze_other->globals_size = \FFI::sizeof($this->ze_other->globals_ptr);
                }
            } else {
                $this->ze_other->globals_size = 0;
                if (\PHP_ZTS)
                    $this->ze_other->globals_id_ptr = null;
                else
                    $this->ze_other->globals_ptr = null;
            }

            $this->ze_other->ini_entry = null;
            $this->ze_other->deps = null;
            $this->ze_other->functions = null;
            $this->ze_other->info_func = \closure_from($this, 'module_info');
            $this->ze_other->module_startup_func = $this->m_startup ? \closure_from($this, 'module_startup') : null;
            $this->ze_other->module_shutdown_func = $this->m_shutdown ? \closure_from($this, 'module_shutdown') : null;

            $this->ze_other->request_startup_func = null;
            if ($this->r_startup) {
                if ($this->restart_sapi)
                    $this->original_sapi_activate = \ze_ffi()->sapi_module->activate;

                $this->ze_other->request_startup_func = \closure_from($this, 'request_startup');
            }

            $this->ze_other->request_shutdown_func = null;
            if ($this->r_shutdown) {
                if ($this->restart_sapi)
                    $this->original_sapi_deactivate = \ze_ffi()->sapi_module->deactivate;

                $this->ze_other->request_shutdown_func = \closure_from($this, 'request_shutdown');
            }

            $this->ze_other->globals_ctor = ($this->g_startup || !\is_null($globalType))
                ? \closure_from($this, 'global_startup') : null;

            $this->ze_other->globals_dtor = ($this->g_shutdown || !\is_null($globalType))
                ? \closure_from($this, 'global_shutdown') : null;

            $this->ze_other->post_deactivate_func = null;
            $this->ze_other->module_started = 0;
            $this->ze_other->handle = null;
            $this->ze_other->module_number = 0;
            $this->ze_other->build_id = \ffi_char(
                'API'
                    . (string)\ZEND_MODULE_API_NO
                    . (\PHP_ZTS ? ',TS' : ',NTS')
                    . (\ZEND_DEBUG_BUILD ? ',debug' : ''),
                false,
                $this->target_persistent
            );

            $this->ze_other_ptr = \FFI::addr($this->ze_other);
            // $module pointer will be updated, as registration method returns a copy of memory
            $this->ze_other_ptr = \ze_ffi()->zend_register_module_ex($this->ze_other_ptr);

            $this->addReflection($moduleName);
            static::set_module($this);
        }

        /**
         * Starts this module.
         *
         * Startup includes calling callbacks for global memory allocation, checking deps, etc
         */
        public function startup(): void
        {
            $module = $this->ze_other_ptr;
            if ($this->restart_sapi) {
                if (\PHP_ZTS) {
                    \ze_ffi()->php_output_end_all();
                    \ze_ffi()->php_output_deactivate();
                    \ze_ffi()->php_output_shutdown();
                }

                \ze_ffi()->sapi_flush();
                \ze_ffi()->sapi_deactivate();

                if (\PHP_ZTS)
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
            }

            if (\ze_ffi()->zend_startup_module_ex($module) !== \ZE::SUCCESS) {
                throw new \RuntimeException('Can not startup module ' . $this->module_name);
            }

            if ($this->r_shutdown)
                \register_shutdown_function(
                    \closure_from($this, 'module_destructor')
                );


            if ($this->restart_sapi) {
                if (\PHP_ZTS)
                    \ze_ffi()->php_output_activate();

                $result = \IS_PHP82
                    ? \ze_ffi()->php_module_startup(\FFI::addr(\ze_ffi()->sapi_module), null)
                    : \ze_ffi()->php_module_startup(\FFI::addr(\ze_ffi()->sapi_module), null, 0);
                if ($result !== \ZE::SUCCESS) {
                    throw new \RuntimeException(
                        'Can not restart SAPI module ' . \ffi_string(\ze_ffi()->sapi_module->name)
                    );
                }
            }
        }

        /**
         * Returns global type (if present) or null if module doesn't use global memory.
         * - Represents `ZEND_DECLARE_MODULE_GLOBALS` _macro_.
         */
        final public function global_type(): ?string
        {
            return $this->global_type;
        }

        /**
         * For `ZTS` mode when using **global_type()**.
         *
         * @return integer|null
         */
        final public function global_type_id(): ?int
        {
            return \PHP_ZTS ? ($this->global_id[\ze_ffi()->tsrm_thread_id()] ?? null) : null;
        }

        /**
         * This getter extends general logic with automatic casting global memory to required type.
         * - Represents `ZEND_MODULE_GLOBALS_ACCESSOR()` _macro_.
         * @param string|null $element field
         * @param mixed $initialize set element value
         * @return null|CData|mixed
         */
        final public function get_globals(string $element = null, $initialize = 'empty')
        {
            $cdata = $this->globals();
            if ($cdata !== null) {
                if (\PHP_ZTS) {
                    $ptr = \ze_ffi()->cast(
                        'void ***',
                        \ze_ffi()->tsrm_get_ls_cache()
                    )[0];

                    $cdata = $this->ffi()->cast($this->global_type(), $ptr[($this->global_type_id() - 1)]);
                } else {
                    $cdata = $this->ffi()->cast($this->global_type(), $cdata);
                }

                if ($initialize !== 'empty' && !\is_null($element)) {
                    \zend_set_global($cdata, $element, $initialize, $this->module_mutex);
                } elseif (!\is_null($element)) {
                    $cdata = \zend_get_global($cdata, $element);
                }
            }

            return $cdata;
        }

        /**
         * Detects a module name by class name.
         */
        private static function detect_name(): string
        {
            $classNameParts = \explode('\\', static::class);
            $className = \end($classNameParts);
            $prefixName = \strstr($className, 'Module', true);
            if ($prefixName !== false) {
                $className = $prefixName;
            }

            // Converts camelCase to snake_case
            $moduleName = \strtolower(\preg_replace_callback('/([a-z])([A-Z])/', function ($match) {
                return $match[1] . '_' . $match[2];
            }, $className));

            return $moduleName;
        }
    }
}
