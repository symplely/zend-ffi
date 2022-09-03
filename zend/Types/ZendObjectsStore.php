<?php

declare(strict_types=1);

namespace ZE;

use FFI\CData;
use ZE\Zval;
use ZE\ZendExecutor;

if (!\class_exists('ZendObjectsStore')) {
    /**
     *```c++
     *typedef struct _zend_objects_store {
     * zend_object **object_buckets;
     * uint32_t top;
     * uint32_t size;
     * int free_list_head;
     *} zend_objects_store;
     *```
     */
    final class ZendObjectsStore extends \ZE implements \Countable, \ArrayAccess
    {
        protected $isZval = false;
        /**
         * @see zend_objects_API.h:OBJ_BUCKET_INVALID macro
         */
        const OBJ_BUCKET_INVALID = 1;

        public function count(): int
        {
            return $this->ze_other_ptr->top - 1;
        }

        public function offsetExists($offset): bool
        {
            $isValidOffset = ($offset >= 0) && ($offset < $this->ze_other_ptr->top);
            $isExists      = $isValidOffset && $this->is_object_valid($this->ze_other_ptr->object_buckets[$offset]);

            return $isExists;
        }

        /**
         * Returns an object from the storage by it's id or null if this object was released
         *
         * @param int $offset Identifier of object
         *
         * @see spl_object_id()
         */
        public function offsetGet($offset): ?ZendObject
        {
            if (!\is_int($offset)) {
                return \ze_ffi()->zend_error(\E_WARNING, 'Object identifier should be an integer');
            }
            if ($offset < 0 || $offset > $this->ze_other_ptr->top - 1) {
                // We use -2 because exception object also increments index by one
                return \ze_ffi()->zend_error(
                    \E_WARNING,
                    "Index %d is out of bounds 0.. %d",
                    $offset,
                    ($this->ze_other_ptr->top - 2)
                );
            }
            $object = $this->ze_other_ptr->object_buckets[$offset];

            // Object can be invalid, for that case we should return null
            if (!$this->is_object_valid($object)) {
                return null;
            }

            $objectEntry = ZendObject::init_value($object);

            return $objectEntry;
        }

        public function offsetSet($offset, $value): void
        {
            \ze_ffi()->zend_error(\E_WARNING, 'Object store is read-only structure');
            return;
        }

        public function offsetUnset($offset): void
        {
            \ze_ffi()->zend_error(\E_WARNING, 'Object store is read-only structure');
            return;
        }

        /**
         * Returns the _free list head_ - the next `handle` id.
         */
        public function list_head(): int
        {
            return $this->ze_other_ptr->free_list_head;
        }

        /**
         * Detaches existing object from the object store
         *
         * - This call doesn't invokes object destructors, only detaches an object from the store.
         *
         * @see zend_objects_API.h:SET_OBJ_INVALID macro
         * @internal
         */
        public function detach(int $offset): void
        {
            if ($offset < 0 || $offset > $this->ze_other_ptr->top - 1) {
                // We use -2 because exception object also increments index by one
                \ze_ffi()->zend_error(\E_WARNING, "Index %d is out of bounds 0..%d", $offset, ($this->ze_other_ptr->top - 2));
                return;
            }

            $rawPointer        = \ze_ffi()->cast('zend_uintptr_t', $this->ze_other_ptr->object_buckets[$offset]);
            $invalidPointer    = $rawPointer->cdata | self::OBJ_BUCKET_INVALID;
            $rawPointer->cdata = $invalidPointer;

            $this->ze_other_ptr->object_buckets[$offset] = \ze_ffi()->cast('zend_object*', $rawPointer);
        }

        /**
         * Checks if the given object pointer is valid or not
         *
         * @see zend_objects_API.h:IS_OBJ_VALID macro
         */
        private function is_object_valid(?CData $objectPointer): bool
        {
            if ($objectPointer === null) {
                return false;
            }

            $rawPointer = \ze_ffi()->cast('zend_uintptr_t', $objectPointer);
            $isValid    = ($rawPointer->cdata & self::OBJ_BUCKET_INVALID) === 0;

            return $isValid;
        }
    }
}
