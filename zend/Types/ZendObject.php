<?php

declare(strict_types=1);

namespace ZE;

use FFI\CData;
use ZE\Zval;
use ZE\HashTable;
use ZE\ZendExecutor;
use ZE\ZendClassEntry;

if (!\class_exists('ZendObject')) {
    /**
     * `ZendObject` represents an object instance in PHP
     *```c++
     * struct _zend_object {
     *   zend_refcounted_h gc;
     *   uint32_t          handle;
     *   zend_class_entry *ce;
     *   const zend_object_handlers *handlers;
     *   HashTable        *properties;
     *   zval              properties_table[1];
     * };
     *```
     */
    final class ZendObject extends \ZE
    {
        protected $isZval = false;
        private HashTable $properties;

        public function __call($method, $args)
        {
            if (\method_exists($this->reflection, $method)) {
                return $this->reflection->$method(...$args);
            } else {
                throw new \Error("$method does not exist");
            }
        }

        public static function init(object $instance): self
        {
            $refValue = Zval::constructor($instance);

            return self::init_value($refValue->obj());
        }

        public static function init_value(CData $ptr): self
        {
            /** @var static */
            $object = (new \ReflectionClass(static::class))->newInstanceWithoutConstructor();
            $object->update($ptr);

            return $object;
        }

        /**
         * Changes the class of object to another one
         *
         * @internal
         */
        public function change(string $newClass): void
        {
            $zvalClass = ZendExecutor::class_table()->find(\strtolower($newClass));
            if ($zvalClass === null) {
                \ze_ffi()->zend_error(\E_WARNING, "Class %s was not found", $newClass);
                return;
            }

            $this->ze_other_ptr->ce = $zvalClass->ce();
        }

        /**
         * Returns an object `handle`, this should be equal to **spl_object_id()**.
         *
         * @param integer|null $newHandle - if set, changes object internal handle to another one
         * @return integer|void
         */
        public function handle(int $newHandle = null)
        {
            if (\is_null($newHandle))
                return $this->ze_other_ptr->handle;

            $this->ze_other_ptr->handle = $newHandle;
        }

        /**
         * Returns a PHP instance of object, associated with this entry
         */
        public function native_value(): object
        {
            $entry = Zval::new(\ZE::IS_OBJECT, $this->ze_other_ptr[0]);
            $entry->native_value($realObject);
            \ffi_free($entry());

            return $realObject;
        }

        public function update(CData $ptr, bool $isOther = false): self
        {
            $this->ze_other_ptr = $ptr;
            if ($this->ze_other_ptr->properties !== null) {
                $this->properties = HashTable::init_value($this->ze_other_ptr->properties);
            }

            return $this;
        }

        /**
         * Returns the `ZendClassEntry` for current object
         */
        public function class_entry(): ZendClassEntry
        {
            return ZendClassEntry::init_value($this->ze_other_ptr->ce);
        }

        public function __debugInfo(): array
        {
            $info = [
                'class'    => $this->class_entry()->getName(),
                'handle'   => $this->handle(),
                'refcount' => $this->gc_refcount()
            ];

            if (isset($this->properties)) {
                $info['properties'] = $this->properties;
            }

            return $info;
        }
    }
}
