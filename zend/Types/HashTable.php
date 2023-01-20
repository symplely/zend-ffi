<?php

declare(strict_types=1);

namespace ZE;

use ZE\Zval;
use ZE\ZendString;

if (!\class_exists('HashTable')) {
    /**
     * Class `HashTable` provides a general instance access to the internal `array` objects, aka hash-table
     *```c++
     * struct _zend_array {
     *     zend_refcounted_h gc;
     *     union {
     *         struct {
     *             zend_uchar    flags;
     *             zend_uchar    _unused;
     *             zend_uchar    nIteratorsCount;
     *             zend_uchar    _unused2;
     *         } v;
     *         uint32_t flags;
     *     } u;
     *     uint32_t          nTableMask;
     *     Bucket           *arData;
     *     uint32_t          nNumUsed;
     *     uint32_t          nNumOfElements;
     *     uint32_t          nTableSize;
     *     uint32_t          nInternalPointer;
     *     zend_long         nNextFreeElement;
     *     dtor_func_t       pDestructor;
     * };
     *```
     */
    final class HashTable extends \ZE implements \IteratorAggregate
    {
        protected $isZval = false;

        public function __destruct()
        {
            $this->ze_other_ptr = null;
            $this->ze_other = null;
        }

        /**
         * Retrieve an external iterator
         *
         * @return \Traversable An instance of an object implementing **Iterator** or **Traversable**
         */
        public function getIterator(): \Iterator
        {
            $iterator = function () {
                $index = 0;
                while ($index < $this->ze_other_ptr->nNumOfElements) {
                    $item = $this->ze_other_ptr->arData[$index];
                    $index++;
                    if ($item->val->u1->v->type === \ZE::IS_UNDEF) {
                        continue;
                    }
                    $key = $item->key !== null ? ZendString::init_value($item->key)->value() : null;
                    yield $key => Zval::init_value($item->val);
                }
            };

            return $iterator();
        }

        /**
         * Represents `zend_hash_str_find_ptr()` inline _macro_.
         *
         * @param string $key
         * @return Zval|null
         */
        public function str_find(string $key): ?Zval
        {
            $string = ZendString::init($key);
            $result = \ze_ffi()->zend_hash_str_find($this->ze_other_ptr, $string->value(), $string->length());

            return \is_cdata($result) ? Zval::init_value($result) : $result;
        }

        /**
         * Performs search by key in the HashTable.
         *
         * @param string $key Key to find
         *
         * @return Zval|null Value or null if not found
         */
        public function find(string $key): ?Zval
        {
            $string = ZendString::init($key);
            $result = \ze_ffi()->zend_hash_find($this->ze_other_ptr, $string->addr());

            return \is_cdata($result) ? Zval::init_value($result) : null;
        }

        /**
         * Deletes a value by key from the HashTable.
         *
         * @param string $key Key in the hash to delete
         * @internal
         */
        public function delete(string $key): self
        {
            $string = ZendString::init($key);
            $result = \ze_ffi()->zend_hash_del($this->ze_other_ptr, $string->addr());

            if ($result === \ZE::FAILURE) {
                return \ze_ffi()->zend_error(\E_WARNING, "Can not delete an item with key %s", $key);
            }

            return $this;
        }

        /**
         * Adds new value to the HashTable
         */
        public function add(string $key, Zval $value): self
        {
            $string = ZendString::init($key);
            $result = \ze_ffi()->zend_hash_add_or_update(
                $this->ze_other_ptr,
                $string->addr(),
                $value(),
                \ZE::HASH_ADD_NEW
            );

            if ($result === \ZE::FAILURE) {
                return \ze_ffi()->zend_error(\E_WARNING, "Can not add an item with key %s", $key);
            }

            return $this;
        }

        public function __debugInfo()
        {
            return \iterator_to_array($this->getIterator());
        }
    }
}
