<?php

declare(strict_types=1);

namespace ZE;

use FFI\CData;
use ZE\ZendReference;
use ZE\ZendExecutor;

if (!\class_exists('Zval')) {
    /**
     * Class `Zval` represents a value in PHP
     *```c++
     * struct _zval_struct {
     *   zend_value        value;            // value
     *   union {
     *     struct {
     *       zend_uchar    type;            // active type, uint8_t - PHP 8.3
     *       zend_uchar    type_flags;      // uint8_t - PHP 8.3
     *       union {
     *         uint16_t  extra;        // not further specified
     *       } u;
     *     } v;
     *     uint32_t type_info;
     *   } u1;
     *   union {
     *     uint32_t     next;                 // hash collision chain
     *     uint32_t     cache_slot;           // cache slot (for RECV_INIT)
     *     uint32_t     opline_num;           // opline number (for FAST_CALL)
     *     uint32_t     lineno;               // line number (for ast nodes)
     *     uint32_t     num_args;             // arguments number for EX(This)
     *     uint32_t     fe_pos;               // foreach position
     *     uint32_t     fe_iter_idx;          // foreach iterator index
     *     uint32_t     access_flags;         // class constant access flags
     *     uint32_t     property_guard;       // single property guard
     *     uint32_t     constant_flags;       // constant flags
     *     uint32_t     extra;                // not further specified
     *   } u2;
     * } zval;
     *```
     *
     *```c++
     * typedef union _zend_value {
     *   zend_long         lval;                // long value
     *   double            dval;                // double value
     *   zend_refcounted  *counted;
     *   zend_string      *str;
     *   zend_array       *arr;
     *   zend_object      *obj;
     *   zend_resource    *res;
     *   zend_reference   *ref;
     *   zend_ast_ref     *ast;
     *   zval             *zv;
     *   void             *ptr;
     *   zend_class_entry *ce;
     *   zend_function    *func;
     *   struct {
     *     uint32_t w1;
     *     uint32_t w2;
     *   } ww;
     * } zend_value;
     *```
     */
    final class Zval extends \ZE
    {
        public function __destruct()
        {
            $this->ze_ptr = null;
        }

        /**
         * Zval `value` constructor for a copy.
         *
         * @param mixed $argument to be extracted
         * @return Zval
         */
        public static function constructor($argument): Zval
        {
            $current = ZendExecutor::init()->call_argument(0);
            $value = Zval::new($current()->u1->type_info, $current()[0]);
            $current->copy($value());

            return $value;
        }

        /**
         * Creates a blank `Zval` _instance_.
         * @return self
         */
        public static function init(): self
        {
            return new static('struct _zval_struct');
        }

        public function func(): CData
        {
            $type = $this->ze_ptr->u1->v->type;
            if ($type !== \ZE::IS_PTR && $type !== \ZE::IS_INDIRECT) {
                return \ze_ffi()->zend_error(\E_WARNING, 'Function creation available only for the type IS_PTR or IS_INDIRECT');
            }

            $function = $this->ze_ptr->value->func;
            // If we have an internal function, then we should cast it to the zend_internal_function
            if ($function->type === \ZE::ZEND_INTERNAL_FUNCTION) {
                $function = \ze_ffi()->cast('zend_internal_function *', $function);
            }

            return $function;
        }

        public function ce(): CData
        {
            $type = $this->ze_ptr->u1->v->type;
            if ($type !== \ZE::IS_PTR && $type !== \ZE::IS_INDIRECT) {
                return \ze_ffi()->zend_error(\E_WARNING, 'Class creation available only for the type IS_PTR or IS_INDIRECT');
            }

            return $this->ze_ptr->value->ce;
        }

        public function ref(): CData
        {
            if ($this->ze_ptr->u1->v->type !== \ZE::IS_REFERENCE) {
                return \ze_ffi()->zend_error(\E_WARNING, 'Reference creation available only for the type IS_REFERENCE');
            }

            return $this->ze_ptr->value->ref;
        }

        public function res(): CData
        {
            if ($this->ze_ptr->u1->v->type !== \ZE::IS_RESOURCE) {
                return \ze_ffi()->zend_error(\E_WARNING, 'Resource creation available only for the type IS_RESOURCE');
            }

            return $this->ze_ptr->value->res;
        }

        public function obj(): CData
        {
            if ($this->ze_ptr->u1->v->type !== \ZE::IS_OBJECT) {
                return \ze_ffi()->zend_error(\E_WARNING, 'Object creation available only for the type IS_OBJECT');
            }

            return $this->ze_ptr->value->obj;
        }

        public function arr(): CData
        {
            if ($this->ze_ptr->u1->v->type !== \ZE::IS_ARRAY) {
                return \ze_ffi()->zend_error(\E_WARNING, 'Array creation available only for the type IS_ARRAY');
            }

            return $this->ze_ptr->value->arr;
        }

        public function ptr(): CData
        {
            if ($this->ze_ptr->u1->v->type !== \ZE::IS_PTR) {
                return \ze_ffi()->zend_error(\E_WARNING, 'Pointer creation available only for the type IS_PTR');
            }

            return $this->ze_ptr->value->ptr;
        }

        public function str(): CData
        {
            if ($this->ze_ptr->u1->v->type !== \ZE::IS_STRING) {
                return \ze_ffi()->zend_error(\E_WARNING, 'String creation available only for the type IS_STRING');
            }

            return $this->ze_ptr->value->str;
        }

        public function zv(): Zval
        {
            if ($this->ze_ptr->u1->v->type !== \ZE::IS_INDIRECT) {
                return \ze_ffi()->zend_error(\E_WARNING, 'Indirect creation available only for the type IS_INDIRECT');
            }

            return \zend_value($this->ze_ptr->value->zv);
        }

        public function extra(): int
        {
            return $this->ze_ptr->u2->extra;
        }

        public function type(): int
        {
            return $this->ze_ptr->u1->type_info;
        }

        /**
         * Returns _native_ value for `userland`.
         *
         * @param mixed $returnValue
         */
        public function native_value(&$returnValue): void
        {
            $reference = ZendReference::init($returnValue);
            $zval = $reference->internal_value();

            $this->copy($zval());
        }

        /**
         * _Change_ the existing value of `userland` to another one.
         *
         * @param mixed $newValue Value to change to
         */
        public function change_value($newValue): void
        {
            $changeZval = ZendExecutor::init()->call_argument(0);
            $changeZval->copy($this->ze_ptr);
        }

        /**
         * Represents `ZVAL_COPY()` _macro_.
         *
         * @param CData $dstZval
         * @param bool $isValue use `ZVAL_COPY_VALUE()` _macro_.
         * @return void
         */
        public function copy(CData $dstZval, bool $isValue = false): void
        {
            $typeInfo = $this->type();
            $gc = $this->gc();

            // Content of ZVAL_COPY_VALUE_EX()
            if (\PHP_INT_SIZE === 4) {
                $w2 = $this->ze_ptr->value->ww->w2;
                $dstZval->value->counted = $gc;
                $dstZval->value->ww->w2 = $w2;
                $dstZval->u1->type_info = $typeInfo;
            } elseif (\PHP_INT_SIZE === 8) {
                $dstZval->value->counted = $gc;
                $dstZval->u1->type_info = $typeInfo;
            } else {
                \ze_ffi()->zend_error(\E_ERROR, 'Unknown SIZEOF_SIZE_T');
            }

            if (!$isValue && $this->is_type_info_refcounted($typeInfo)) {
                $this->gc_addRef();
            }
        }

        public function __debugInfo(): array
        {
            $this->native_value($nativeValue);

            return [
                'type' => self::name($this->ze_ptr->u1->v->type),
                'value' => $nativeValue
            ];
        }

        /**
         * Creates a new zval from it's type and value.
         *
         * @param int $type Value type
         * @param CData $value Value, should be zval-compatible
         *
         * @return Zval
         */
        public static function new(int $type, CData $value, bool $isPersistent = false): Zval
        {
            // Allocate non-owned Zval
            $entry = \ze_ffi()->new('zval', false, $isPersistent);

            $entry->u1->type_info = $type;
            $entry->value->zv = \ze_ffi()->cast('zval', $value);

            return static::init_value(\ffi_ptr($entry));
        }

        /**
         * Represents various **accessor** macros.
         *
         * @param string|int $accessor One of:
         *
         * - Macro                          Return/Set type
         * - `ZE::TRUE`                 for `ZVAL_TRUE()`
         * - `ZE::FALSE`                for `ZVAL_FALSE()`
         * - `ZE::NULL`                 for `ZVAL_NULL()`
         * - `ZE::UNDEF`                for `ZVAL_UNDEF()`
         * - `ZE::BOOL`                 for `ZVAL_BOOL()`       `unsigned char`
         * -
         * - `ZE::TYPE_P`               for `Z_TYPE_P()`        `unsigned char`
         * - `ZE::TYPE_INFO_P`          for `Z_TYPE_INFO_P()`   `unsigned char`
         * - `ZE::REFCOUNTED`           for `Z_REFCOUNTED()`    `boolean`
         * - `ZE::TYPE_INFO_REFCOUNTED` for `Z_TYPE_INFO_REFCOUNTED()` `boolean`
         * - `ZE::LVAL_P`               for `Z_LVAL_P()`        `zend_long`
         * - `ZE::DVAL_P`               for `Z_DVAL_P()`        `double`
         * - `ZE::STR_P`                for `Z_STR_P()`         `zend_string *`
         * - `ZE::STRVAL_P`             for `Z_STRVAL_P()`      `char *`
         * - `ZE::STRLEN_P`             for `Z_STRLEN_P()`      `size_t`
         * - `ZE::ARR_P`                for `Z_ARR_P()`         `HashTable *`
         * - `ZE::ARRVAL_P`             for `Z_ARRVAL_P()`      `HashTable *`
         * - `ZE::OBJ_P`                for `Z_OBJ_P()`         `zend_object *`
         * - `ZE::OBJCE_P`              for `Z_OBJCE_P()`       `zend_class_entry *`
         * - `ZE::RES_P`                for `Z_RES_P()`         `zend_resource *`
         * - `ZE::REF_P`                for `Z_REF_P()`         `zend_reference *`
         * - `ZE::REFVAL_P`             for `Z_REFVAL_P()`      `zval *`
         * - `ZE::COUNTED_P`            for `Z_COUNTED_P()`     `*`
         *
         * @param mixed|CData|null $valuePtr a `value/pointer` to set to.
         * @return self|mixed|CData|bool|int
         */
        public function macro($accessor, $valuePtr = null)
        {
            switch ($accessor) {
                case \ZE::TYPE_P:
                    if (\is_null($valuePtr))
                        return $this->ze_ptr->u1->v->type;
                    break;
                case \ZE::REFCOUNTED:
                    return $this->ze_ptr->u1->type_flags != 0;
                case \ZE::TYPE_INFO_REFCOUNTED:
                    return ($this->ze_ptr->u1->type_info & (\ZE::IS_TYPE_REFCOUNTED << \ZE::Z_TYPE_FLAGS_MASK)) != 0;
                case \ZE::LVAL_P:
                    if (\is_null($valuePtr))
                        return $this->ze_ptr->value->lval;

                    $this->ze_ptr->value->lval = $valuePtr;
                    $this->ze_ptr->u1->type_info = \ZE::IS_LONG;
                    break;
                case \ZE::DVAL_P:
                    if (\is_null($valuePtr))
                        return $this->ze_ptr->value->dval;

                    $this->ze_ptr->value->dval = $valuePtr;
                    $this->ze_ptr->u1->type_info = \ZE::IS_DOUBLE;
                    break;
                case \ZE::STR_P:
                    if (\is_null($valuePtr))
                        return $this->ze_ptr->value->str;

                    $this->ze_ptr->value->str = $valuePtr;
                    $this->ze_ptr->u1->type_info = ($this->gc_flags($valuePtr) & \ZE::IS_STR_INTERNED)
                        ? \ZE::IS_INTERNED_STRING_EX
                        : \ZE::IS_STRING_EX;
                    break;
                case \ZE::STRVAL_P:
                    return $this->ze_ptr->value->str->val;
                case \ZE::ARR_P:
                case \ZE::ARRVAL_P:
                    if (\is_null($valuePtr))
                        return $this->ze_ptr->value->arr;

                    $this->ze_ptr->value->arr = $valuePtr;
                    $this->ze_ptr->u1->type_info = \ZE::IS_ARRAY_EX;
                    break;
                case \ZE::RES_P:
                    if (\is_null($valuePtr))
                        return $this->ze_ptr->value->res;

                    $this->ze_ptr->value->res = $valuePtr;
                    $this->ze_ptr->u1->type_info = \ZE::IS_RESOURCE_EX;
                    break;
                case \ZE::OBJ_P:
                    if (\is_null($valuePtr))
                        return $this->ze_ptr->value->obj;

                    $this->ze_ptr->value->obj = $valuePtr;
                    $this->ze_ptr->u1->type_info = \ZE::IS_OBJECT_EX;
                    break;
                case \ZE::OBJCE_P:
                    if (\is_null($valuePtr))
                        return $this->ze_ptr->value->obj->ce;
                case \ZE::COUNTED_P:
                    if (\is_null($valuePtr))
                        return $this->ze_ptr->value->counted;
                    break;
                case \ZE::PTR_P:
                    if (\is_null($valuePtr))
                        return $this->ze_ptr->value->ptr;
                    break;
                case \ZE::ARR_P:
                    if (\is_null($valuePtr))
                        return $this->ze_ptr->value->arr;
                    break;
                case \ZE::REFVAL_P:
                    if (\is_null($valuePtr))
                        return $this->ze_ptr->value->ref->val;
                    break;
                case \ZE::REF_P:
                    if (\is_null($valuePtr))
                        return $this->ze_ptr->value->ref;

                    $this->ze_ptr->value->ref = $valuePtr;
                    $this->ze_ptr->u1->type_info = \ZE::IS_REFERENCE_EX;
                    break;
                case \ZE::TYPE_INFO_P:
                    if (\is_null($valuePtr))
                        return $this->ze_ptr->u1->type_info;

                    $accessor = $valuePtr;
                case \ZE::TRUE:
                case \ZE::FALSE:
                case \ZE::NULL:
                case \ZE::UNDEF:
                case \ZE::BOOL:
                    $valuePtr = $accessor === \ZE::BOOL
                        ? ($valuePtr ? \ZE::IS_TRUE : \ZE::IS_FALSE)
                        : $accessor;

                    $this->ze_ptr->u1->type_info = $valuePtr;
                    break;
            }

            return $this;
        }
    }
}
