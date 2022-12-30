<?php

declare(strict_types=1);

namespace ZE;

use FFI\CData;
use ZE\Zval;
use ZE\HashTable;
use ZE\ZendString;
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
    class ZendPropertyInfo extends \ZE
    {
        protected $isZval = false;

        public function __construct(string $className, string $propertyName)
        {
            //     parent::__construct($className, $propertyName);

            //      $normalizedName  = strtolower($className);
            //    $classEntryValue = Core::$executor->classTable->find($normalizedName);
            //      if ($classEntryValue === null) {
            //            throw new \ReflectionException("Class {$className} should be in the engine.");
            //         }
            //         $classEntry      = $classEntryValue->getRawClass();
            //      $propertiesTable = new HashTable(Core::addr($classEntry->properties_info));

            //    $propertyEntry = $propertiesTable->find(strtolower($propertyName));
            //    if ($propertyEntry === null) {
            //           throw new \ReflectionException("Property {$propertyName} was not found in the class.");
            //       }
            //        $propertyPointer = $propertyEntry->getRawPointer();
            //     $this->pointer   = Core::cast('zend_property_info *', $propertyPointer);
        }

        /**
         * @return ZendPropertyInfo|\ReflectionProperty
         */
        public static function init_value(CData $ptr): self
        {
            /** @var ZendPropertyInfo */
            $property = (new \ReflectionClass(static::class))->newInstanceWithoutConstructor();

            $propertyName = ZendString::init_value($ptr->name);
            $property->update($ptr);
            return $property->addReflection($propertyName->value());
        }

        /**
         * Returns an offset of this property
         */
        public function getOffset(): int
        {
            return $this->ze_other_ptr->offset;
        }

        /**
         * Declares property as public
         */
        public function setPublic(): void
        {
            $this->ze_other_ptr->flags &= (~\ZE::ZEND_ACC_PPP_MASK);
            $this->ze_other_ptr->flags |= \ZE::ZEND_ACC_PUBLIC;
        }

        /**
         * Declares property as protected
         */
        public function setProtected(): void
        {
            $this->ze_other_ptr->flags &= (~\ZE::ZEND_ACC_PPP_MASK);
            $this->ze_other_ptr->flags |= \ZE::ZEND_ACC_PROTECTED;
        }

        /**
         * Declares property as private
         */
        public function setPrivate(): void
        {
            $this->ze_other_ptr->flags &= (~\ZE::ZEND_ACC_PPP_MASK);
            $this->ze_other_ptr->flags |= \ZE::ZEND_ACC_PRIVATE;
        }

        /**
         * Declares property as static/non-static
         */
        public function setStatic(bool $isStatic = true): void
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
            $lcName = strtolower($className);

            //  $classEntryValue = Core::$executor->classTable->find($lcName);
            //    if ($classEntryValue === null) {
            //      throw new \ReflectionException("Class {$className} was not found");
            //  }
            //   $this->ze_other_ptr->ce = $classEntryValue->getRawClass();
        }

        /**
         * Returns a user-friendly representation of internal structure to prevent segfault
         */
        public function __debugInfo(): array
        {
            return [
                'name'   => $this->getName(),
                'offset' => $this->getOffset(),
                'type'   => $this->getType(),
                'class'  => $this->getDeclaringClass()->getName()
            ];
        }
    }
}
