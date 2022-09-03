<?php

declare(strict_types=1);

namespace ZE;

use ZE\Zval;
use ZE\ZendExecutor;

if (!\class_exists('ZendString')) {
    /**
     * This class wraps PHP's `zend_string` structure, `string` instance, and provide an API for working with it
     *```c++
     * struct _zend_string {
     *   zend_refcounted_h gc;
     *   zend_ulong        h;                // hash value
     *   size_t            len;
     *   char              val[1];
     * };
     *```
     */
    final class ZendString extends \ZE
    {
        protected $isZval = false;

        public static function init($string): ZendString
        {
            return static::init_value(
                ZendExecutor::init()->call_argument(0)->str()[0]
            );
        }

        /**
         * Returns a hash for given string
         */
        public function hash(): int
        {
            return $this->ze_other_ptr->h;
        }

        /**
         * Returns a string length
         */
        public function length(): int
        {
            return $this->ze_other_ptr->len;
        }

        /**
         * Returns a PHP representation of engine string
         */
        public function value(): string
        {
            $zval = Zval::new(\ZE::IS_STRING, $this->ze_other_ptr[0]);
            $zval->native_value($realString);
            \ffi_free($zval());

            return $realString;
        }

        /**
         * This methods releases a string entry
         *
         * @see zend_string.h:zend_string_release function
         */
        public function release(): void
        {
            if (!$this->is_variable(\ZE::GC_IMMUTABLE)) {
                if ($this->gc_delRef() === 0) {
                    $this->free();
                }
            }
        }

        /**
         * Creates a copy of string value
         *
         * @see zend_string.h::zend_string_copy function
         *
         * @return self
         */
        public function copy(): self
        {
            if (!$this->is_variable(\ZE::GC_IMMUTABLE)) {
                $this->gc_addRef();
            }

            return $this;
        }

        public function __debugInfo(): array
        {
            return [
                'value'    => $this->value(),
                'length'   => $this->length(),
                'refcount' => $this->gc_refcount(),
                'hash'     => $this->hash(),
            ];
        }
    }
}
