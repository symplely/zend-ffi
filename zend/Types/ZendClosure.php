<?php

declare(strict_types=1);

namespace ZE;

use FFI\CData;
use ZE\Zval;
use ZE\ZendObject;
use ZE\ZendString;
use ZE\ZendExecutor;

if (!\class_exists('ZendClosure')) {
    /**
     * `ZendClosure` represents an closure instance in PHP
     *```c++
     * typedef struct _zend_closure {
     *   zend_object       std;
     *   zend_function     func;
     *   zval              this_ptr;
     *   zend_class_entry *called_scope;
     *   zif_handler       orig_internal_handler;
     * } zend_closure;
     *```
     */
    final class ZendClosure extends \ZE
    {
        protected $isZval = false;
        protected $this_ptr = null;

        public static function init(\Closure $closure): self
        {
            $zendClosure = static::init_value(
                \ze_ffi()->cast('zend_closure *', ZendExecutor::init()->call_argument(0)->obj())
            );

            return $zendClosure->addThis($zendClosure());
        }

        /**
         * Returns a `ZendObject` that represents this closure
         */
        public function std(): ZendObject
        {
            return ZendObject::init_value($this->ze_other_ptr->std);
        }

        public function addThis(CData $ptr): self
        {
            $this->this_ptr = $ptr->this_ptr;

            return $this;
        }

        /**
         * Returns the called scope (if present), otherwise null for unbound closures
         */
        public function called_scope(): ?string
        {
            if ($this->ze_other_ptr->called_scope === null) {
                return null;
            }

            $calledScopeName = ZendString::init_value($this->ze_other_ptr->called_scope->name);

            return $calledScopeName->value();
        }

        /**
         * Changes the scope of closure to another one
         * @internal
         */
        public function change(?string $newScope): void
        {
            // If we have a null value, then just clean this scope internally
            if ($newScope === null) {
                $this->ze_other_ptr->called_scope = null;
                return;
            }

            $zvalClass = ZendExecutor::class_table()->find(\strtolower($newScope));
            if ($zvalClass === null) {
                \ze_ffi()->zend_error(\E_WARNING, "Class %s was not found", $newScope);
                return;
            }

            $this->ze_other_ptr->called_scope = $zvalClass->ce();
        }

        /**
         * Changes the current $this, bound to the closure
         *
         * @param object $object New object
         *
         * @internal
         */
        public function changeThis(object $object): void
        {
            $zvalStack = ZendExecutor::init()->call_argument(0);
            $objectZval = $zvalStack();
            \FFI::memcpy($this->this_ptr, $objectZval[0], \FFI::sizeof(\ze_ffi()->type('zval')));
        }

        /**
         * Returns `zend_function` data for this closure
         */
        public function func(): CData
        {
            return $this->ze_other_ptr->func;
        }
    }
}
