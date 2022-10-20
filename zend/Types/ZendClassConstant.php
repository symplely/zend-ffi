<?php

declare(strict_types=1);

namespace ZE;

use FFI\CData;
use ZE\Zval;
use ZE\HashTable;
use ZE\ZendString;
use ZE\ZendExecutor;
use ZE\ZendClassEntry;

if (!\class_exists('ZendClassConstant')) {
    /**
     * Class `ZendClassConstant`
     *
     *```c++
     * typedef struct _zend_class_constant {
     *     zval value; // access flags are stored in reserved: zval.u2.access_flags
     *     zend_string *doc_comment;
     *     HashTable *attributes; // Only PHP 8 or higher
     *     zend_class_entry *ce;
     * } zend_class_constant;
     *```
     */
    final class ZendClassConstant extends \ZE
    {
        protected $isZval = false;

        /**
         * @return ZendClassConstant|\ReflectionClassConstant
         */
        public static function init(string $className, string $constantName)
        {
            $classZval = ZendExecutor::init()->class_table()->find(\strtolower($className));
            if ($classZval === null) {
                return \ze_ffi()->zend_error(\E_WARNING, "Class %s should be in the engine.", $className);
            }

            $ce = $classZval->ce();
            $constantsTable  = HashTable::init_value(\ffi_ptr($ce->constants_table));

            $constantEntry = $constantsTable->find($constantName);
            if ($constantEntry === null) {
                return \ze_ffi()->zend_error(\E_WARNING, "Constant {} was not found in the class.", $constantName);
            }

            $constantPointer = $constantEntry->ptr();
            return static::init_values(\ze_ffi()->cast('zend_class_constant *', $constantPointer), $constantName);
        }

        /**
         * @return ZendClassConstant|\ReflectionClassConstant
         */
        public static function init_values(CData $ptr, string $constantName): self
        {
            /** @var ZendClassConstant */
            $constant = (new \ReflectionClass(static::class))->newInstanceWithoutConstructor();
            $className = ZendString::init_value($ptr->ce->name);

            $constant->update($ptr);
            return $constant->addReflection($className->value(), $constantName);
        }

        /**
         * @return ZendClassConstant|\ReflectionClassConstant
         */
        public function addReflection(string ...$arguments): self
        {
            $this->reflection = new \ReflectionClassConstant(\array_shift($arguments), \reset($arguments));

            return $this;
        }

        /**
         * Declares constant as public
         */
        public function public(): void
        {
            $this->ze_other_ptr->value->u2->access_flags &= (~\ZE::ZEND_ACC_PPP_MASK);
            $this->ze_other_ptr->value->u2->access_flags |= \ZE::ZEND_ACC_PUBLIC;
        }

        /**
         * Declares constant as protected
         */
        public function protected(): void
        {
            $this->ze_other_ptr->value->u2->access_flags &= (~\ZE::ZEND_ACC_PPP_MASK);
            $this->ze_other_ptr->value->u2->access_flags |= \ZE::ZEND_ACC_PROTECTED;
        }

        /**
         * Declares constant as private
         */
        public function private(): void
        {
            $this->ze_other_ptr->value->u2->access_flags &= (~\ZE::ZEND_ACC_PPP_MASK);
            $this->ze_other_ptr->value->u2->access_flags |= \ZE::ZEND_ACC_PRIVATE;
        }

        /**
         * Gets the declaring class, or changes the declaring class name for this property
         *
         * @param string $className New class name for this property
         * @return ZendClassEntry|void
         */
        public function declaringClass(string $className = null)
        {
            if (\is_null($className))
                return ZendClassEntry::init_value($this->ze_other_ptr->ce);

            $classZval = ZendExecutor::init()->class_table()->find(\strtolower($className));
            if ($classZval === null) {
                return \ze_ffi()->zend_error(\E_WARNING, "Class %s was not found", $className);
            }

            $this->ze_other_ptr->ce = $classZval->ce();
        }

        /**
         * Returns a `Zval` instance for this constant
         */
        public function getZval(): Zval
        {
            return Zval::init_value($this->ze_other_ptr->value);
        }

        public function __debugInfo(): array
        {
            return [
                'name'   => $this->reflection->getName(),
                'class'  => $this->declaringClass()->getName(),
            ];
        }
    }
}
