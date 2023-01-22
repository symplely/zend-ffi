<?php

declare(strict_types=1);

namespace ZE;

use FFI\CData;
use ZE\ZendExecutor;
use ZE\ZendClassEntry;


if (!\class_exists('ZendPropertyInfo')) {
    /**
     * Class `ZendPropertyInfo`
     *
     *```cpp
     * typedef struct _zend_property_info {
     *     uint32_t offset; // property offset for object properties or property index for static properties
     *     uint32_t flags;
     *     zend_string *name;
     *     zend_string *doc_comment;
     *     zend_class_entry *ce;
     *     zend_type type;
     * } zend_property_info;
     *```
     */
    final class ZendPropertyInfo extends \ZE
    {
        protected $isZval = false;

        /**
         * @return ZendPropertyInfo|\ReflectionProperty
         */
        public static function init(string $className, string $propertyName)
        {
            /** @var ZendPropertyInfo */
            $property = (new \ReflectionClass(static::class))->newInstanceWithoutConstructor();
            $classEntryValue = ZendExecutor::class_table()->find(\strtolower($className));
            if ($classEntryValue === null) {
                return \ze_ffi()->zend_error(\E_WARNING, "Class %s should be in the engine.", $className);
            }

            $classEntry = $classEntryValue->ce();
            $propertiesTable = \hash_table(\FFI::addr($classEntry->properties_info));

            $propertyEntry = $propertiesTable->find(\strtolower($propertyName));
            if ($propertyEntry === null) {
                return \ze_ffi()->zend_error(\E_WARNING, "Property %s was not found in the class.", $propertyName);
            }


            $propertyPointer = $propertyEntry();
            $property->addReflection($className, $propertyName);
            $property->update(\ze_ffi()->cast('zend_property_info *', $propertyPointer));

            return $property;
        }

        /**
         * @return ZendPropertyInfo|\ReflectionProperty
         */
        public static function init_value(CData $ptr): self
        {
            /** @var ZendPropertyInfo */
            $property = (new \ReflectionClass(static::class))->newInstanceWithoutConstructor();

            $propertyName = \zend_string($ptr->name);
            $property->update($ptr);

            return $property->addReflection($propertyName->value());
        }

        /**
         * Returns an offset of this property
         */
        public function offset(): int
        {
            return $this->ze_other_ptr->offset;
        }

        /**
         * Declares property as public
         */
        public function public(): void
        {
            $this->ze_other_ptr->flags &= (~\ZE::ZEND_ACC_PPP_MASK);
            $this->ze_other_ptr->flags |= \ZE::ZEND_ACC_PUBLIC;
        }

        /**
         * Declares property as protected
         */
        public function protected(): void
        {
            $this->ze_other_ptr->flags &= (~\ZE::ZEND_ACC_PPP_MASK);
            $this->ze_other_ptr->flags |= \ZE::ZEND_ACC_PROTECTED;
        }

        /**
         * Declares property as private
         */
        public function private(): void
        {
            $this->ze_other_ptr->flags &= (~\ZE::ZEND_ACC_PPP_MASK);
            $this->ze_other_ptr->flags |= \ZE::ZEND_ACC_PRIVATE;
        }

        /**
         * Declares property as static/non-static
         */
        public function static(bool $isStatic = true): void
        {
            if ($isStatic) {
                $this->ze_other_ptr->flags |= \ZE::ZEND_ACC_STATIC;
            } else {
                $this->ze_other_ptr->flags &= (~\ZE::ZEND_ACC_STATIC);
            }
        }

        /**
         * Gets the declaring class
         */
        public function getDeclaringClass(): ZendClassEntry
        {
            return ZendClassEntry::init_value($this->ze_other_ptr->ce);
        }

        /**
         * Changes the declaring class name for this property
         *
         * @param string $className New class name for this property
         * @internal
         */
        public function declaringClass(string $className): void
        {
            $classEntryValue = ZendExecutor::class_table()->find(\strtolower($className));
            if ($classEntryValue === null) {
                \ze_ffi()->zend_error(\E_WARNING, "Class %s was not found", $className);
                return;
            }

            $this->ze_other_ptr->ce = $classEntryValue->ce();
        }

        /**
         * Returns a user-friendly representation of internal structure to prevent segfault
         */
        public function __debugInfo(): array
        {
            return [
                'name'   => $this->reflection->getName(),
                'offset' => $this->offset(),
                'type'   => $this->reflection->getType(),
                'class'  => $this->getDeclaringClass()->getName()
            ];
        }
    }
}
