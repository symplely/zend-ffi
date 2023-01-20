<?php

declare(strict_types=1);

namespace ZE;

use FFI\CData;
use ZE\Zval;
use ZE\ZendFunction;
use ZE\ZendExecutor;
use ZE\ZendClassEntry;

if (!\class_exists('ZendMethod')) {
    final class ZendMethod extends ZendFunction
    {
        /**
         * @return ZendMethod|\ReflectionMethod
         */
        public static function init(string ...$arguments): self
        {
            $className = \array_shift($arguments);
            $methodName = \reset($arguments);

            /** @var Zval */
            $zvalClass = \zend_hash_find(\strtolower($className), static::executor_globals()->class_table);
            if ($zvalClass === null) {
                return \ze_ffi()->zend_error(\E_WARNING, "Class %s should be in the engine.", $className);
            }

            $classPtr = $zvalClass->ce();

            /** @var Zval */
            $zvalMethod = \zend_hash_find(\strtolower($methodName), \ffi_ptr($classPtr->function_table));
            if ($zvalMethod === null) {
                return \ze_ffi()->zend_error(\E_WARNING, "Method %s was not found in the class.", $methodName);
            }

            return self::init_value($zvalMethod->func());
        }

        /**
         * @return ZendMethod|\ReflectionMethod
         */
        public function addReflection(string ...$arguments): self
        {
            $this->reflection = new \ReflectionMethod(\array_shift($arguments), \reset($arguments));

            return $this;
        }

        /**
         * @return ZendMethod|\ReflectionMethod
         */
        public static function init_value(CData $ptr): self
        {
            if ($ptr->type !== \ZE::ZEND_INTERNAL_FUNCTION) {
                $functionNamePtr = $ptr->common->function_name;
                $scopeNamePtr = $ptr->common->scope->name;
            } else {
                $functionNamePtr = $ptr->function_name;
                $scopeNamePtr = $ptr->scope->name;
            }

            $scopeName = ZendString::init_value($scopeNamePtr)->value();
            $functionName = ZendString::init_value($functionNamePtr)->value();

            /** @var ZendMethod|\ReflectionMethod */
            $method = (new \ReflectionClass(static::class))->newInstanceWithoutConstructor();
            $method->update($ptr);

            return $method->addReflection($scopeName, $functionName);
        }

        /**
         * Declares function as final/non-final
         */
        public function final(bool $isFinal = true): void
        {
            if ($isFinal) {
                $this->getPtr()->fn_flags |= \ZE::ZEND_ACC_FINAL;
            } else {
                $this->getPtr()->fn_flags &= (~\ZE::ZEND_ACC_FINAL);
            }
        }

        /**
         * Declares function as abstract/non-abstract
         */
        public function abstract(bool $isAbstract = true): void
        {
            if ($isAbstract) {
                $this->getPtr()->fn_flags |= \ZE::ZEND_ACC_ABSTRACT;
            } else {
                $this->getPtr()->fn_flags &= (~\ZE::ZEND_ACC_ABSTRACT);
            }
        }

        /**
         * Declares method as public
         */
        public function public(): void
        {
            $this->getPtr()->fn_flags &= (~\ZE::ZEND_ACC_PPP_MASK);
            $this->getPtr()->fn_flags |= \ZE::ZEND_ACC_PUBLIC;
        }

        /**
         * Declares method as protected
         */
        public function protected(): void
        {
            $this->getPtr()->fn_flags &= (~\ZE::ZEND_ACC_PPP_MASK);
            $this->getPtr()->fn_flags |= \ZE::ZEND_ACC_PROTECTED;
        }

        /**
         * Declares method as private
         */
        public function private(): void
        {
            $this->getPtr()->fn_flags &= (~\ZE::ZEND_ACC_PPP_MASK);
            $this->getPtr()->fn_flags |= \ZE::ZEND_ACC_PRIVATE;
        }

        /**
         * Declares method as static/non-static
         */
        public function static(bool $isStatic = true): void
        {
            if ($isStatic) {
                $this->getPtr()->fn_flags |= \ZE::ZEND_ACC_STATIC;
            } else {
                $this->getPtr()->fn_flags &= (~\ZE::ZEND_ACC_STATIC);
            }
        }

        /**
         * Returns the method prototype or null if no prototype for this method
         */
        public function prototype(): ?ZendMethod
        {
            if ($this->getPtr()->prototype === null) {
                return null;
            }

            return static::init_value($this->getPtr()->prototype);
        }

        /**
         * Gets the declaring class, or changes the declaring class name for this method
         *
         * @param string|null $set New class name for this method
         * @return ZendClassEntry|ZendMethod
         */
        public function declaringClass(string $set = null): object
        {
            if (\is_null($set)) {
                if ($this->getPtr()->scope === null) {
                    return \ze_ffi()->zend_error(\E_WARNING, 'Not in a class scope');
                }

                return ZendClassEntry::init_value($this->getPtr()->scope);
            }

            $classEntryValue = ZendExecutor::init()->class_table()->find(\strtolower($set));
            if ($classEntryValue === null) {
                return \ze_ffi()->zend_error(\E_WARNING, "Class %s was not found", $set);
            }

            $this->getPtr()->scope = $classEntryValue->ce();

            return $this;
        }

        public function __debugInfo(): array
        {
            return [
                'name'  => $this->reflection->getName(),
                'class' => $this->declaringClass()->getName()
            ];
        }

        /**
         * Returns the hash key for function or method
         */
        protected function getHash(): string
        {
            return $this->reflection->class . '::' . $this->reflection->name;
        }
    }
}
