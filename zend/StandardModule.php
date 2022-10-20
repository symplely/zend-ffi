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
     * _The following `3` properties MUST be declared:_
     *```php
     * protected string $ffi_tag = 'instance';
     *
     * // If not set, class name will be used as module name
     * protected ?string $module_name = 'extension name';
     * protected ?string $module_version = '0.0.0';
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
        private const NO_VERSION_YET = null;
        /**
         * `ZTS|NTS` _ts_rsrc_id_ or _C typedef_ **instance**
         */
        private ?\CStruct $global_rsrc = null;

        /**
         * `ZTS` _ts_rsrc_id_
         */
        private array $global_id = [];

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
        protected string $ffi_tag = 'ze';

        /**
         * Unique name of this module
         */
        protected ?string $module_name = null;

        /**
         * Version number of this module
         */
        protected ?string $module_version = self::NO_VERSION_YET;

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

        final public function __destruct()
        {
            if (\PHP_ZTS) {
                $id = \ze_ffi()->tsrm_thread_id();
                if (isset($this->global_id[$id])) {
                    \ze_ffi()->ts_free_id($this->global_id[$id]);
                    unset($this->global_id[$id]);
                }
            }

            $this->global_rsrc = null;
            $this->free();
        }

        /**
         * Module constructor.
         *
         * @param string $version Version number of this module
         * @param string $ffi_tag **ffi** _instance_ of module
         * @param string $name Unique name of this module
         * - If not set, class name will be used as module name
         * @param boolean $target_persistent - Set true if this module should be persistent or false if temporary
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
            string $version = self::NO_VERSION_YET,
            string $ffi_tag = null,
            string $name = null,
            bool $target_persistent = false,
            bool $target_threads = \ZEND_THREAD_SAFE,
            bool $target_debug = \ZEND_DEBUG_BUILD,
            int $target_version = self::ZEND_MODULE_API_NO
        ) {
            if (!\is_null($ffi_tag))
                $this->ffi_tag = $ffi_tag;

            if (!\is_null($name) || \is_null($this->module_name))
                $this->module_name = $name ?? self::detect_name();

            if (\is_null($this->module_version))
                $this->module_version = $version;

            $this->target_threads = $target_threads;
            $this->target_persistent = $target_persistent;
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
         * @param CData $memory `void*` needs to be __cast__ to `global_type()`
         * @return void
         */
        public function global_startup(CData $memory): void
        {
            if (\PHP_ZTS) {
                \tsrmls_activate();
                $id = \ze_ffi()->tsrm_thread_id();
                if (!isset($this->global_id[$id])) {
                    $this->global_id[$id] = \ze_ffi()->ts_allocate_id(
                        $this->global_rsrc->addr(),
                        $this->globals_size(),
                        null,
                        null
                    );
                }
            }

            \FFI::memset($this->get_globals(), 0, $this->globals_size());
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
            \tsrmls_deactivate();
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
        final public function get_name(): string
        {
            return $this->module_name;
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

            // We don't need persistent memory here, as PHP copies structures into persistent memory itself
            $module = \ze_ffi()->new('zend_module_entry');
            $moduleName = $this->module_name;
            $module->size = \FFI::sizeof($module);
            $module->type = $this->target_persistent ? self::MODULE_PERSISTENT : self::MODULE_TEMPORARY;
            $module->name = \ffi_char($moduleName, false, $this->target_persistent);
            $module->zend_api = $this->target_version;
            $module->zend_debug = (int)$this->target_debug;
            $module->zts = (int)$this->target_threads;
            if (!\is_null($this->module_version))
                $module->version = \ffi_char($this->module_version);

            $globalType = $this->global_type();
            if (!\is_null($globalType)) {
                $module->globals_size = \FFI::sizeof(\FFI::type($globalType));
                if (\PHP_ZTS) {
                    $this->global_rsrc = \c_int_type('ts_rsrc_id', 'ze', null, false, $this->target_persistent);
                    $module->globals_id_ptr = $this->global_rsrc->addr();
                    $this->global_id[\ze_ffi()->tsrm_thread_id()] = \ze_ffi()->ts_allocate_id(
                        $this->global_rsrc->addr(),
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

            if ($this->r_startup)
                $module->request_startup_func = \closure_from($this, 'request_startup');

            if ($this->r_shutdown)
                $module->request_shutdown_func = \closure_from($this, 'request_shutdown');

            if ($this->g_startup || !\is_null($globalType))
                $module->globals_ctor = \closure_from($this, 'global_startup');

            if ($this->g_shutdown || !\is_null($globalType))
                $module->globals_dtor = \closure_from($this, 'global_shutdown');

            // $module pointer will be updated, as registration method returns a copy of memory
            $realModulePointer = \ze_ffi()->zend_register_module_ex(\FFI::addr($module));

            $this->update($realModulePointer);
            $this->addReflection($moduleName);
        }

        /**
         * Starts this module.
         *
         * Startup includes calling callbacks for global memory allocation, checking deps, etc
         */
        final public function startup(): void
        {
            $result = \ze_ffi()->zend_startup_module_ex($this->ze_other_ptr);
            if ($result !== \ZE::SUCCESS) {
                throw new \RuntimeException('Can not startup module ' . $this->module_name);
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
         * This getter extends general logic with automatic casting global memory to required type.
         * - Represents `ZEND_MODULE_GLOBALS_ACCESSOR()` _macro_.
         * @param string|null $element
         * @return null|CData|mixed
         */
        final public function get_globals(string $element = null)
        {
            $cdata = $this->globals();
            if ($cdata !== null) {
                if (\PHP_ZTS) {
                    $ptr = \ze_ffi()->cast(
                        'void ***',
                        \tsrmls_cache()
                    )[0];
                    $cdata = \Core::get($this->ffi_tag)->cast($this->global_type(), $ptr[($this->global_id[\ze_ffi()->tsrm_thread_id()] - 1)]);
                } else
                    $cdata = \Core::get($this->ffi_tag)->cast($this->global_type(), $cdata);
            }

            return \is_null($element) ? $cdata : $cdata->{$element};
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
