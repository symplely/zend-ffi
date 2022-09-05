<?php

declare(strict_types=1);

namespace ZE;

use FFI\CData;
use ZE\Zval;

if (!\class_exists('ZendModule')) {
    /**
     * `ZendModule` provides information about hooking into and creating extensions
     *```c++
     * struct _zend_module_entry {
     *   unsigned short size;
     *   unsigned int zend_api;
     *   unsigned char zend_debug;
     *   unsigned char zts;
     *   const struct _zend_ini_entry *ini_entry;
     *   const struct _zend_module_dep *deps;
     *   const char *name;
     *   const struct _zend_function_entry *functions;
     *   int (*module_startup_func)(int type, int module_number);
     *   int (*module_shutdown_func)(int type, int module_number);
     *   int (*request_startup_func)(int type, int module_number);
     *   int (*request_shutdown_func)(int type, int module_number);
     *   void (*info_func)(zend_module_entry *zend_module);
     *   const char *version;
     *   size_t globals_size;
     * #ifdef ZTS
     *   ts_rsrc_id* globals_id_ptr;
     * #else
     *   void* globals_ptr;
     * #endif
     *   void (*globals_ctor)(void *global);
     *   void (*globals_dtor)(void *global);
     *   int (*post_deactivate_func)(void);
     *   int module_started;
     *   unsigned char type;
     *   void *handle;
     *   int module_number;
     *   const char *build_id;
     * };
     *```
     */
    final class ZendModule extends \ZE
    {
        protected $isZval = false;

        protected \ReflectionExtension $reflection;

        public function __call($method, $args)
        {
            if (\method_exists($this->reflection, $method)) {
                return $this->reflection->$method(...$args);
            } else {
                throw new \Error("$method does not exist");
            }
        }

        /**
         * @return ZendModule|\ReflectionExtension
         */
        public function addReflection(string $name)
        {
            $this->reflection = new \ReflectionExtension($name);

            return $this;
        }

        /**
         * @return ZendModule|\ReflectionExtension
         */
        public static function init(string $name): self
        {
            /** @var Zval */
            $ext = HashTable::init_value(static::module_registry())
                ->find($name);
            if ($ext === null) {
                return \ze_ffi()->zend_error(\E_WARNING, "Module %s should be in the engine.", $name);
            }

            return static::init_value(
                \ze_ffi()->cast('zend_module_entry*', $ext->ptr())
            );
        }

        /**
         * @return ZendModule|\ReflectionExtension
         */
        public static function init_value(CData $ptr): self
        {
            /** @var ZendModule|\ReflectionExtension */
            $module = (new \ReflectionClass(static::class))->newInstanceWithoutConstructor();
            $module->update($ptr);

            return $module->addReflection($ptr->name);
        }

        /**
         * Returns the size of module itself
         *
         * Typically, this should be equal to Core::type('zend_module_entry')
         */
        public function size(): int
        {
            return $this->ze_other_ptr->size;
        }

        /**
         * Returns the size of module global structure
         */
        public function globals_size(): int
        {
            return $this->ze_other_ptr->globals_size;
        }

        /**
         * Returns a pointer (if any) to global memory area or null if extension doesn't use global memory structure
         */
        public function globals(): ?CData
        {
            if (\ZEND_THREAD_SAFE) {
                return $this->ze_other_ptr->globals_id_ptr;
            } else {
                return $this->ze_other_ptr->globals_ptr;
            }
        }

        /**
         * Was module started or not
         */
        public function module_started(): bool
        {
            return (bool) $this->ze_other_ptr->module_started;
        }

        /**
         * Is module was compiled/designed for debug mode
         */
        public function is_debug(): bool
        {
            return (bool) $this->ze_other_ptr->zend_debug;
        }

        /**
         * Is module compiled with thread safety or not
         */
        public function is_thread_safe(): bool
        {
            return (bool) $this->ze_other_ptr->zts;
        }

        /**
         * Returns the module ordinal number
         */
        public function module_number(): int
        {
            return $this->ze_other_ptr->module_number;
        }

        /**
         * Returns the api version
         */
        public function zend_api(): int
        {
            return $this->ze_other_ptr->zend_api;
        }

        public function __debugInfo()
        {
            if (!isset($this->ze_other_ptr)) {
                return [];
            }

            $result  = [];
            $methods = (new \ReflectionClass(self::class))->getMethods(\ReflectionMethod::IS_PUBLIC);
            foreach ($methods as $method) {
                $methodName = $method->getName();
                $hasZeroArgs = $method->getNumberOfRequiredParameters() === 0;
                if ((\strpos($methodName, 'get') === 0) && $hasZeroArgs) {
                    $friendlyName = \lcfirst(\substr($methodName, 3));
                    $result[$friendlyName] = $this->$methodName();
                }

                if ((\strpos($methodName, 'is') === 0) && $hasZeroArgs) {
                    $friendlyName = \lcfirst(\substr($methodName, 2));
                    $result[$friendlyName] = $this->$methodName();
                }
            }

            return $result;
        }
    }
}
