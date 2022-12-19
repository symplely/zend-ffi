<?php

declare(strict_types=1);

use FFI\CData;
use ZE\Zval;
use ZE\HashTable;
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
         * @see zend_modules.h:MODULE_PERSISTENT
         */
        private const MODULE_PERSISTENT = 1;

        /**
         * @see zend_modules.h:MODULE_TEMPORARY
         */
        private const MODULE_TEMPORARY = 2;

        private const ZEND_MODULE_API_NO = 20190902;

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
        protected int $target_version = self::ZEND_MODULE_API_NO;

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

        protected static $global_module;

        protected bool $destruct_on_request = false;

        /** @var \Closure */
        protected ?CData $original_sapi_activate = null;

        /** @var \Closure */
        protected ?CData $original_sapi_deactivate = null;

        /** @var \MUTEX_T */
        protected ?CData $module_mutex = null;

        /**
         * Set __`StandardModule`__ to call `module_shutdown()` and `global_shutdown()`
         * on __`request_shutdown()`__ or __`module_destructor()`__.
         *
         * @return void
         */
        public function destruct_set(): void
        {
            $this->destruct_on_request = true;
        }

        public function is_destruct(): bool
        {
            return $this->destruct_on_request;
        }

        /**
         * Executes `request_shutdown()`, and if __destruct_on_request__ is `true`, _module_shutdown()_ and _global_shutdown()_.
         *
         * @return void
         */
        final public function module_destructor(): void
        {
            if ($this->r_shutdown) {
                $module = $this->__invoke();
                if (!\is_null($module)) {
                    try {
                        //code...
                        $this->request_shutdown($module->type, $module->module_number);
                        if ($this->destruct_on_request && !$this->target_persistent) {
                            $this->destruct_on_request = false;
                            $this->module_shutdown($module->type, $module->module_number);
                            $this->global_shutdown($module);
                        }
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
                }
            }
        }

        final protected static function set_module(?\StandardModule $module): void
        {
            if (\PHP_ZTS)
                self::$global_module[\ze_ffi()->tsrm_thread_id()] = $module;
            else
                self::$global_module = $module;
        }

        /**
         * Represents `ZEND_GET_MODULE()` _macro_.
         *
         * @return static|null
         */
        final public static function get_module(): ?self
        {
            if (\PHP_ZTS)
                return static::$global_module[\ze_ffi()->tsrm_thread_id()] ?? null;

            return self::$global_module;
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

        public function __destruct()
        {
            if (\is_ze_ffi()) {
                if (!$this->target_persistent && !is_null($this->get_module())) {
                    if (\PHP_ZTS) {
                        $id = \ze_ffi()->tsrm_thread_id();
                        if (isset($this->global_id[$id])) {
                            \ze_ffi()->ts_free_id($this->global_id[$id]);
                            unset($this->global_id[$id]);
                            unset($this->global_rsrc[$id]);
                        }

                        \ze_ffi()->tsrm_mutex_free($this->module_mutex);
                        $this->module_mutex = null;
                    } else {
                        $this->global_rsrc = null;
                    }

                    if ($this->r_startup) {
                        \ze_ffi()->sapi_module->activate = $this->original_sapi_activate;
                        $this->original_sapi_activate = null;
                    }

                    if ($this->r_shutdown) {
                        \ze_ffi()->sapi_module->deactivate = $this->original_sapi_deactivate;
                        $this->original_sapi_deactivate = null;
                    }

                    static::set_module(null);
                    $this->free();
                }
            } elseif (!\is_null($this->get_module())) {
                $this->global_rsrc = null;
                static::set_module(null);
                $this->free();
            }
        }

        /**
         * Module constructor.
         *
         * @param boolean $target_threads Use `ZEND_THREAD_SAFE` as default if your module does not depend on thread-safe mode.
         * - Set the thread-safe mode for this module.
         * @param boolean $target_debug Use `ZEND_DEBUG_BUILD` as default if your module does not depend on debug mode.
         * - Set the debug mode for this module.
         * @param int $target_version `ZEND_MODULE_API_NO`
         * - Set the API version for this module
         *
         * @return self
         */
        final public function __construct(
            bool $target_threads = \ZEND_THREAD_SAFE,
            bool $target_debug = \ZEND_DEBUG_BUILD,
            int $target_version = self::ZEND_MODULE_API_NO
        ) {
            if (!isset($this->ffi_tag))
                return \ze_ffi()->zend_error(\E_ERROR, 'No `FFI` instance found!');

            if (!isset($this->module_name))
                $this->module_name = self::detect_name();

            $this->target_threads = $target_threads;
            $this->target_debug = $target_debug;
            $this->target_version = $target_version;

            // if module is already registered, then we can use it immediately
            if ($this->is_registered()) {
                /** @var Zval */
                $ext = HashTable::init_value(static::module_registry())->find($this->module_name);
                if ($ext === null) {
                    return \ze_ffi()->zend_error(\E_WARNING, "Module %s should be in the engine.", $this->module_name);
                }

                $ptr = $ext->ptr();
                $this->update(\ze_ffi()->cast('zend_module_entry*', $ptr));
                $this->addReflection($ptr->name);
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
         * @param mixed $args
         * @return integer
         */
        public function request_startup(...$args): int
        {
            return \ZE::SUCCESS;
        }

        /**
         * Represents `PHP_RSHUTDOWN_FUNCTION()` _macro_.
         *
         * @param mixed $args
         * @return integer
         */
        public function request_shutdown(...$args): int
        {
            return \ZE::SUCCESS;
        }

        /**
         * Represents `PHP_GINIT_FUNCTION()` _macro_.
         *
         * @param CData $memory `void*` needs to be __cast__ to `global_type()`
         * @return void
         */
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
        }

        /**
         * Represents `PHP_GSHUTDOWN_FUNCTION()` _macro_.
         *
         * @param CData $memory `void*` needs to be __cast__ to `global_type()`
         * @return void
         */
        public function global_shutdown(CData $memory): void
        {
            $this->__destruct();
        }

        /**
         * Represents `PHP_MINFO_FUNCTION()` _macro_.
         *
         * @param CData $entry
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

            $this->target_persistent = \Core::is_scoped(); // \ini_get('opcache.enable_cli') === '1';

            // We don't need persistent memory here, as PHP copies structures into persistent memory itself
            $module = \ze_ffi()->new('zend_module_entry');
            $moduleName = $this->module_name;
            $module->size = \FFI::sizeof($module);
            $module->type = $this->target_persistent ? self::MODULE_PERSISTENT : self::MODULE_TEMPORARY;
            $module->name = \ffi_char($moduleName, false, $this->target_persistent);
            $module->zend_api = $this->target_version;
            $module->zend_debug = (int)$this->target_debug;
            $module->zts = (int)$this->target_threads;
            if (isset($this->module_version))
                $module->version = \ffi_char($this->module_version, false, $this->target_persistent);

            $globalType = $this->global_type();
            if (!\is_null($globalType)) {
                $module->globals_size = \FFI::sizeof($this->ffi()->type($globalType));
                if (\PHP_ZTS) {
                    $id = \ze_ffi()->tsrm_thread_id();
                    $this->global_rsrc[$id] = \c_int_type('ts_rsrc_id', 'ze', null, false, $this->target_persistent);
                    $module->globals_id_ptr = $this->global_rsrc[$id]->addr();
                    $this->global_id[$id] = \ze_ffi()->ts_allocate_id(
                        $this->global_rsrc[$id]->addr(),
                        $module->globals_size,
                        null,
                        null
                    );
                } else {
                    $this->global_rsrc = \c_typedef($globalType, $this->ffi_tag, false, $this->target_persistent);
                    $module->globals_ptr = $this->global_rsrc->addr();
                }
            }

            $module->info_func = \closure_from($this, 'module_info');
            if ($this->m_startup)
                $module->module_startup_func = \closure_from($this, 'module_startup');

            if ($this->m_shutdown)
                $module->module_shutdown_func = \closure_from($this, 'module_shutdown');

            if ($this->r_startup) {
                $this->original_sapi_activate = \ze_ffi()->sapi_module->activate;
                $module->request_startup_func = \closure_from($this, 'request_startup');
            }

            if ($this->r_shutdown) {
                $this->original_sapi_deactivate = \ze_ffi()->sapi_module->deactivate;
                $module->request_shutdown_func = \closure_from($this, 'request_shutdown');
            }

            if ($this->g_startup || !\is_null($globalType))
                $module->globals_ctor = \closure_from($this, 'global_startup');

            if ($this->g_shutdown || !\is_null($globalType))
                $module->globals_dtor = \closure_from($this, 'global_shutdown');

            // $module pointer will be updated, as registration method returns a copy of memory
            $realModulePointer = \ze_ffi()->zend_register_module_ex(\FFI::addr($module));

            $this->update($realModulePointer);
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
            if ($this->restart_sapi) {
                \ze_ffi()->php_output_end_all();
                \ze_ffi()->php_output_deactivate();
                \ze_ffi()->php_output_shutdown();
                \ze_ffi()->sapi_flush();
                \ze_ffi()->sapi_deactivate();
                \ze_ffi()->sapi_shutdown();
            }

            $module = $this->ze_other_ptr;
            if ($this->r_startup) {
                \ze_ffi()->sapi_module->activate = function (...$args) use ($module) {
                    $result = ($module->request_startup_func)($module->type, $module->module_number);
                    $sapi_result = !\is_null($this->original_sapi_activate) ? ($this->original_sapi_activate)(...$args) : \ZE::SUCCESS;

                    return $result == $sapi_result && $result === \ZE::SUCCESS
                        ? \ZE::SUCCESS : \ZE::FAILURE;
                };
            }

            if ($this->r_shutdown) {
                \ze_ffi()->sapi_module->deactivate = \PHP_ZTS ? null : function (...$args) use ($module) {
                    $result = ($module->request_shutdown_func)($module->type, $module->module_number);
                    $sapi_result = !\is_null($this->original_sapi_deactivate) ? ($this->original_sapi_deactivate)(...$args) : \ZE::SUCCESS;

                    return $result == $sapi_result && $result === \ZE::SUCCESS
                        ? \ZE::SUCCESS : \ZE::FAILURE;
                };
            }

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
                    if (\PHP_ZTS)
                        \ze_ffi()->tsrm_mutex_lock($this->module_mutex);

                    if (\strpos($element, '[', 0) === 0 || \is_numeric($element)) {
                        $index = (int)(\is_numeric($element) ? $element : \str_replace(['[', ']'], '', $element));
                        $cdata[$index] = $initialize;
                    } elseif (\strpos($element, '->') !== false) {
                        $fields = \explode('->', $element);
                        if (\count($fields) == 3)
                            $cdata->{$fields[0]}->{$fields[1]}->{$fields[2]} = $initialize;
                        elseif (\count($fields) == 2)
                            $cdata->{$fields[0]}->{$fields[1]} = $initialize;
                    } else {
                        $cdata->{$element} = $initialize;
                    }

                    if (\PHP_ZTS)
                        \ze_ffi()->tsrm_mutex_unlock($this->module_mutex);
                } elseif (!\is_null($element)) {
                    if ((\strpos($element, '[', 0) === 0) || \is_numeric($element)) {
                        $index = (int)(\is_numeric($element) ? $element : \str_replace(['[', ']'], '', $element));
                        $elements = $cdata[$index];
                    } elseif (\strpos($element, '->') !== false) {
                        $fields = \explode('->', $element);
                        if (\count($fields) == 3)
                            $elements = $cdata->{$fields[0]}->{$fields[1]}->{$fields[2]};
                        elseif (\count($fields) == 2)
                            $elements = $cdata->{$fields[0]}->{$fields[1]};
                    } else {
                        $elements = $cdata->{$element};
                    }

                    $cdata = $elements;
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
