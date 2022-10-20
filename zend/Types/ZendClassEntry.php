<?php

declare(strict_types=1);

namespace ZE;

use FFI\CData;
use ZE\Zval;
use ZE\HashTable;
use ZE\ZendMethod;
use ZE\ZendString;
use ZE\ZendExecutor;

if (!\class_exists('ZendClassEntry')) {
    /**
     * @return ZendClassEntry|\ReflectionClass
     */
    class ZendClassEntry extends \ZE
    {
        protected $isZval = false;

        /**
         * Stores the list of methods in the class
         *
         * @var HashTable|Zval[]
         */
        private HashTable $methodTable;

        /**
         * Stores the list of properties in the class
         *
         * @var HashTable|Zval[]
         */
        private HashTable $propertiesTable;

        /**
         * Stores the list of constants in the class
         *
         * @var HashTable|Zval[]
         */
        private HashTable $constantsTable;

        /**
         * Stores the list of attributes
         *
         * @var ?HashTable|Zval[]
         */
        private ?HashTable $attributesTable;

        /**
         * Stores all allocated zend_object_handler pointers per class
         */
        private static array $objectHandlers = [];

        /**
         * @return ZendClassEntry|\ReflectionClass
         */
        public function __construct($nameOrObject)
        {
            $className = \is_string($nameOrObject) ? $nameOrObject : \get_class($nameOrObject);
            $zvalClassEntry = ZendExecutor::class_table()->find(\strtolower($className));
            if ($zvalClassEntry === null) {
                return \ze_ffi()->zend_error(\E_WARNING, 'Class %s should be in the engine.', $className);
            }

            $this->ze_other_ptr = $zvalClassEntry->ce();
            $this->initLowLevel($this->ze_other_ptr);
            $this->addReflection($nameOrObject);
        }

        /**
         * @return ZendClassEntry|\ReflectionClass
         */
        public function addReflection(string $name): self
        {
            $this->reflection = new \ReflectionClass($name);

            return $this;
        }

        /**
         * @return ZendClassEntry|\ReflectionClass
         */
        public static function init($nameOrObject): ZendClassEntry
        {
            return new static($nameOrObject);
        }

        /**
         * @return ZendClassEntry|\ReflectionClass
         */
        public static function init_value(CData $ptr): self
        {
            /** @var static */
            $class = (new \ReflectionClass(static::class))->newInstanceWithoutConstructor();
            $classNameValue = ZendString::init_value($ptr->name);
            $class->initLowLevel($ptr);

            return $class->addReflection($classNameValue->value());
        }

        public function isInternal(): bool
        {
            return \ord($this->ze_other_ptr->type) === \ZE::ZEND_INTERNAL_CLASS;
        }

        public function isUserDefined(): bool
        {
            return \ord($this->ze_other_ptr->type) === \ZE::ZEND_USER_CLASS;
        }

        public function getName(): string
        {
            return ZendString::init_value($this->ze_other_ptr->name)->value();
        }

        /**
         * Returns the list of default properties. Only for non-static ones
         *
         * @return iterable|Zval[]
         */
        public function getDefaultProperties(): iterable
        {
            $iterator = function () {
                $propertyIndex = 0;
                while ($propertyIndex < $this->ze_other_ptr->default_properties_count) {
                    $value = $this->ze_other_ptr->default_properties_table[$propertyIndex];
                    yield $propertyIndex => Zval::init_value($value);
                    $propertyIndex++;
                }
            };

            return iterator_to_array($iterator());
        }

        public function getParentClass(): ?ZendClassEntry
        {
            if (!$this->hasParent()) {
                return null;
            }

            // For linked class we should look at parent name directly
            if ($this->ze_other_ptr->ce_flags & \ZE::ZEND_ACC_LINKED) {
                $rawParentName = $this->ze_other_ptr->parent->name;
            } else {
                $rawParentName = $this->ze_other_ptr->parent_name;
            }

            $parentNameValue = ZendString::init_value($rawParentName);
            $classReflection = new ZendClassEntry($parentNameValue->value());

            return $classReflection;
        }

        /**
         * Removes the linked parent class from the existing class
         * @internal
         */
        public function removeParent(): void
        {
            if (!$this->hasParent()) {
                \ze_ffi()->zend_error(\E_ERROR, 'Could not remove non-existent parent class');
            }

            try {
                $parentClass = $this->getParentClass();
                $parentInterfaces = $parentClass->getInterfaceNames();
                if (\count($parentInterfaces) > 0) {
                    $this->removeInterfaces(...$parentInterfaces);
                }

                $methodsToRemove = [];
                foreach ($this->getMethods() as $reflectionMethod) {
                    $methodClass = $reflectionMethod->declaringClass();
                    $methodClassName = $methodClass->getName();
                    $isParentMethod = $parentClass->getName() === $methodClassName;
                    $isGrandMethod = $parentClass->isSubclassOf($methodClassName);

                    if ($isParentMethod || $isGrandMethod) {
                        $methodsToRemove[] = $reflectionMethod->getName();
                    }
                }

                if (\count($methodsToRemove) > 0) {
                    $this->removeMethods(...$methodsToRemove);
                }
            } catch (\ReflectionException $e) {
                // This can happen during the class-loading (parent not loaded yet). But we ignore this error
            }

            // TODO: Detach all related constants, properties, etc...
            $this->ze_other_ptr->parent = null;
        }

        /**
         * Configures a new parent class for this one
         *
         * @param string $newParent New parent class name
         * @internal
         */
        public function parent(string $newParent)
        {
            // If this class has a parent, then we need to detach it first
            if ($this->hasParent()) {
                $this->removeParent();
            }

            // Look for the parent zend_class_entry
            $parentClassValue = ZendExecutor::init()->class_table()->find(strtolower($newParent));
            if ($parentClassValue === null) {
                \ze_ffi()->zend_error(\E_ERROR, "Class %s was not found", $newParent);
            }

            // Call API to reduce the boilerplate code
            \ze_ffi()->zend_do_inheritance_ex($this->ze_other_ptr, $parentClassValue->ce(), 0);
        }

        /**
         * @return ZendMethod|\ReflectionMethod
         */
        public function getMethod($name): ZendMethod
        {
            $functionEntry = $this->methodTable->find(strtolower($name));
            if ($functionEntry === null) {
                return \ze_ffi()->zend_error(\E_WARNING, "Method {} does not exist", $name);
            }

            return ZendMethod::init_value($functionEntry->func());
        }

        /**
         * @return ZendMethod[]
         */
        public function getMethods($filter = null): array
        {
            $methods = [];
            foreach ($this->methodTable as $methodEntryValue) {
                $functionEntry = $methodEntryValue->func();
                if (!isset($filter) || ($functionEntry->common->fn_flags & $filter)) {
                    $methods[] = ZendMethod::init_value($functionEntry);
                }
            }

            return $methods;
        }

        public function getInterfaceNames(): array
        {
            $interfaceNames = [];
            $isLinked = (bool) ($this->ze_other_ptr->ce_flags & \ZE::ZEND_ACC_LINKED);
            for ($index = 0; $index < $this->ze_other_ptr->num_interfaces; $index++) {
                if ($isLinked) {
                    $rawInterfaceName = $this->ze_other_ptr->interfaces[$index]->name;
                } else {
                    $rawInterfaceName = $this->ze_other_ptr->interface_names[$index]->name;
                }

                $interfaceNameValue = ZendString::init_value($rawInterfaceName);
                $interfaceNames[] = $interfaceNameValue->value();
            }

            return $interfaceNames;
        }

        /**
         * Gets the interfaces
         *
         * @return ZendClassEntry[] An associative array of interfaces, with keys as interface
         * names and the array values as **ZendClassEntry** objects.
         */
        public function getInterfaces(): array
        {
            $interfaces = [];
            foreach ($this->getInterfaceNames() as $interfaceName) {
                $interfaces[$interfaceName] = new ZendClassEntry($interfaceName);
            };

            return $interfaces;
        }

        /**
         * Removes given methods from the class
         *
         * @param string ...$methodNames Name of methods to remove
         * @internal
         */
        public function removeMethods(string ...$methodNames): void
        {
            foreach ($methodNames as $methodName) {
                $this->methodTable->delete(\strtolower($methodName));
            }
        }

        /**
         * Adds a new method to the class in runtime
         * @internal
         */
        public function addMethod(string $methodName, \Closure $method): ZendMethod
        {
            $closureEntry = ZendClosure::init($method);
            $closureEntry->std()->gc_addRef();
            $closureEntry->change($this->reflection->name);

            $rawFunction = $closureEntry->func();
            $rawFunction->common->function_name = ZendString::init($methodName)();

            // Adjust the scope of our function to our class
            $classScopeValue = ZendExecutor::init()->class_table()->find(\strtolower($this->reflection->name));
            $rawFunction->common->scope = $classScopeValue->ce();

            // Clean closure flag
            $rawFunction->common->fn_flags &= (~\ZE::ZEND_ACC_CLOSURE);

            $isPersistent = $this->isInternal() || \PHP_SAPI !== 'cli';
            $refMethod = $this->initMethod($methodName, $rawFunction, $isPersistent);
            $refMethod->public();

            return $refMethod;
        }

        /**
         * Gets the traits
         *
         * @return getTraitNames[] An associative array of traits, with keys as trait
         * names and the array values as **ZendClassEntry** objects.
         */
        public function getTraits(): array
        {
            $traits = [];
            foreach ($this->reflection->getTraitNames() as $traitName) {
                $traits[$traitName] = new ZendClassEntry($traitName);
            };

            return $traits;
        }

        /**
         * Adds traits to the current class
         *
         * @param string ...$traitNames Name of traits to add
         * @internal
         */
        public function addTraits(string ...$traitNames): void
        {
            $availableTraits = $this->reflection->getTraitNames();
            $traitsToAdd = \array_values(\array_diff($traitNames, $availableTraits));
            $numTraitsToAdd = \count($traitsToAdd);
            $totalTraits = \count($availableTraits);
            $numResultTraits = $totalTraits + $numTraitsToAdd;

            // Memory should be non-owned to keep it live more that $memory variable in this method.
            // If this class is internal then we should use persistent memory
            // If this class is user-defined and we are not in CLI, then use persistent memory, otherwise non-persistent
            $isPersistent = $this->isInternal() || \PHP_SAPI !== 'cli';
            $memory = \ze_ffi()->new("zend_class_name [$numResultTraits]", false, $isPersistent);

            $itemsSize = \FFI::sizeof(\ze_ffi()->type('zend_class_name'));
            if ($totalTraits > 0) {
                \FFI::memcpy($memory, $this->ze_other_ptr->trait_names, $itemsSize * $totalTraits);
            }

            for ($position = $totalTraits, $index = 0; $index < $numTraitsToAdd; $position++, $index++) {
                $traitName = $traitsToAdd[$index];
                $name = ZendString::init($traitName);
                $lcName = ZendString::init(\strtolower($traitName));

                $memory[$position]->name = $name();
                $memory[$position]->lc_name = $lcName();
            }

            // As we don't have realloc methods in PHP, we can free non-persistent memory to prevent leaks
            if ($totalTraits > 0 && !$isPersistent) {
                \FFI::free($this->ze_other_ptr->trait_names);
            }

            $this->ze_other_ptr->trait_names = \ze_ffi()->cast('zend_class_name *', \ffi_ptr($memory));
            $this->ze_other_ptr->num_traits = $numResultTraits;
        }

        /**
         * Removes traits from the current class
         *
         * @param string ...$traitNames Name of traits to remove
         * @internal
         */
        public function removeTraits(string ...$traitNames): void
        {
            $availableTraits = $this->reflection->getTraitNames();
            $indexesToRemove = [];
            foreach ($traitNames as $traitToRemove) {
                $traitPosition = \array_search($traitToRemove, $availableTraits, true);
                if ($traitPosition === false) {
                    \ze_ffi()->zend_error(\E_ERROR, "Trait %s doesn't belong to the class", $traitToRemove);
                }

                $indexesToRemove[$traitPosition] = true;
            }

            $totalTraits = \count($availableTraits);
            $numResultTraits = $totalTraits - \count($indexesToRemove);

            // Memory should be non-owned to keep it live more that $memory variable in this method.
            // If this class is internal then we should use persistent memory
            // If this class is user-defined and we are not in CLI, then use persistent memory, otherwise non-persistent
            $isPersistent = $this->isInternal() || \PHP_SAPI !== 'cli';

            if ($numResultTraits > 0) {
                $memory = \ze_ffi()->new("zend_class_name[$numResultTraits]", false, $isPersistent);
            } else {
                $memory = null;
            }

            for ($index = 0, $destIndex = 0; $index < $totalTraits; $index++) {
                $traitNameStruct = $this->ze_other_ptr->trait_names[$index];
                if (!isset($indexesToRemove[$index])) {
                    $memory[$destIndex++] = $traitNameStruct;
                } else {
                    // Clean strings to prevent memory leaks
                    ZendString::init_value($traitNameStruct->name)->release();
                    ZendString::init_value($traitNameStruct->lc_name)->release();
                }
            }

            if ($totalTraits > 0 && !$isPersistent) {
                \FFI::free($this->ze_other_ptr->trait_names);
            }

            if ($numResultTraits > 0) {
                $this->ze_other_ptr->trait_names = \ze_ffi()->cast('zend_class_name *', \ffi_ptr($memory));
            } else {
                $this->ze_other_ptr->trait_names = null;
            }

            $this->ze_other_ptr->num_traits = $numResultTraits;
        }

        /**
         * Adds interfaces to the current class
         *
         * @param string ...$interfaceNames Name of interfaces to add
         *
         * @see zend_inheritance.c:zend_do_implement_interface() function implementation for details
         * @internal
         */
        public function addInterfaces(string ...$interfaceNames): void
        {
            $availableInterfaces = $this->getInterfaceNames();
            $interfacesToAdd = \array_values(\array_diff($interfaceNames, $availableInterfaces));
            $numInterfacesToAdd = \count($interfacesToAdd);
            $totalInterfaces = \count($availableInterfaces);
            $numResultInterfaces = $totalInterfaces + $numInterfacesToAdd;

            // Memory should be non-owned to keep it live more that $memory variable in this method.
            // If this class is internal then we should use persistent memory
            // If this class is user-defined and we are not in CLI, then use persistent memory, otherwise non-persistent
            $isPersistent = $this->isInternal() || \PHP_SAPI !== 'cli';
            $memory = \ze_ffi()->new("zend_class_entry *[$numResultInterfaces]", false, $isPersistent);

            $itemsSize = \FFI::sizeof($memory[0]);
            if ($totalInterfaces > 0) {
                \FFI::memcpy($memory, $this->ze_other_ptr->interfaces, $itemsSize * $totalInterfaces);
            }

            for ($position = $totalInterfaces, $index = 0; $index < $numInterfacesToAdd; $position++, $index++) {
                $interfaceName = $interfacesToAdd[$index];
                if (!\interface_exists($interfaceName)) {
                    \ze_ffi()->zend_error(\E_ERROR, "Interface %s was not found", $interfaceName);
                }

                $memory[$position] = ZendExecutor::init()->class_table()->find(\strtolower($interfaceName))->ce();
            }

            // As we don't have realloc methods in PHP, we can free non-persistent memory to prevent leaks
            if ($totalInterfaces > 0 && !$isPersistent) {
                \FFI::free($this->ze_other_ptr->interfaces);
            }

            $this->ze_other_ptr->interfaces = \ze_ffi()->cast('zend_class_entry **', \ffi_ptr($memory));

            // We should also add ZEND_ACC_RESOLVED_INTERFACES explicitly with first interface
            if ($totalInterfaces === 0 && $numInterfacesToAdd > 0) {
                $this->ze_other_ptr->ce_flags |= \ZE::ZEND_ACC_RESOLVED_INTERFACES;
            }

            $this->ze_other_ptr->num_interfaces = $numResultInterfaces;
        }

        /**
         * Removes interfaces from the current class
         *
         * @param string ...$interfaceNames Name of interfaces to remove
         * @internal
         */
        public function removeInterfaces(string ...$interfaceNames): void
        {
            $availableInterfaces = $this->getInterfaceNames();
            $indexesToRemove = [];
            foreach ($interfaceNames as $interfaceToRemove) {
                $interfacePosition = \array_search($interfaceToRemove, $availableInterfaces, true);
                if ($interfacePosition === false) {
                    \ze_ffi()->zend_error(\E_ERROR, "Interface %s doesn't belong to the class", $interfaceToRemove);
                }

                $indexesToRemove[$interfacePosition] = true;
            }

            $totalInterfaces = \count($availableInterfaces);
            $numResultInterfaces = $totalInterfaces - \count($indexesToRemove);

            // Memory should be non-owned to keep it live more that $memory variable in this method.
            // If this class is internal then we should use persistent memory
            // If this class is user-defined and we are not in CLI, then use persistent memory, otherwise non-persistent
            $isPersistent = $this->isInternal() || \PHP_SAPI !== 'cli';

            // If we remove all interfaces then just clear $this->ze_other_ptr->interfaces field
            if ($numResultInterfaces === 0) {
                if ($totalInterfaces > 0 && !$isPersistent) {
                    \FFI::free($this->ze_other_ptr->interfaces);
                }

                // We should also clean ZEND_ACC_RESOLVED_INTERFACES
                $this->ze_other_ptr->interfaces = null;
                $this->ze_other_ptr->ce_flags &= (~\ZE::ZEND_ACC_RESOLVED_INTERFACES);
            } else {
                // Allocate non-owned memory, either persistent (for internal classes) or not (for user-defined)
                $memory = \ze_ffi()->new("zend_class_entry *[$numResultInterfaces]", false, $isPersistent);
                for ($index = 0, $destIndex = 0; $index < $this->ze_other_ptr->num_interfaces; $index++) {
                    if (!isset($indexesToRemove[$index])) {
                        $memory[$destIndex++] = $this->ze_other_ptr->interfaces[$index];
                    }
                }

                if ($totalInterfaces > 0 && !$isPersistent) {
                    \FFI::free($this->ze_other_ptr->interfaces);
                }

                $this->ze_other_ptr->interfaces = \ze_ffi()->cast('zend_class_entry **', \ffi_ptr($memory));
            }

            // Decrease the total number of interfaces in the class entry
            $this->ze_other_ptr->num_interfaces = $numResultInterfaces;
        }

        /**
         * Sets a new start line for the class in the file
         */
        public function line_start(int $newStartLine): void
        {
            if (!$this->isUserDefined()) {
                \ze_ffi()->zend_error(\E_ERROR, 'Line can be configured only for user-defined class');
            }

            $this->ze_other_ptr->info->user->line_start = $newStartLine;
        }

        /**
         * Sets a new end line for the class in the file
         */
        public function line_end(int $newEndLine): void
        {
            if (!$this->isUserDefined()) {
                \ze_ffi()->zend_error(\E_ERROR, 'Line can be configured only for user-defined class');
            }

            $this->ze_other_ptr->info->user->line_end = $newEndLine;
        }

        /**
         * Sets a new filename for this class
         */
        public function filename(string $newFileName): void
        {
            if (!$this->isUserDefined()) {
                \ze_ffi()->zend_error(\E_ERROR, 'File can be configured only for user-defined class');
            }

            $stringEntry = ZendString::init($newFileName);
            $this->ze_other_ptr->info->user->filename = $stringEntry();
        }

        /**
         * Declares this class as abstract/non-abstract
         *
         * @param bool $isAbstract True to make current class abstract or false to remove abstract flag
         */
        public function abstract(bool $isAbstract = true): void
        {
            if ($isAbstract) {
                $this->ze_other_ptr->ce_flags->cdata = ($this->ze_other_ptr->ce_flags | \ZE::ZEND_ACC_EXPLICIT_ABSTRACT_CLASS);
            } else {
                $this->ze_other_ptr->ce_flags->cdata = ($this->ze_other_ptr->ce_flags & (~\ZE::ZEND_ACC_EXPLICIT_ABSTRACT_CLASS));
                $this->ze_other_ptr->ce_flags->cdata = ($this->ze_other_ptr->ce_flags & (~\ZE::ZEND_ACC_IMPLICIT_ABSTRACT_CLASS));
            }
        }

        /**
         * Declares this class as final/non-final
         *
         * @param bool $isFinal True to make class final/false to remove final flag
         */
        public function final(bool $isFinal = true): void
        {
            if ($isFinal) {
                $this->ze_other_ptr->ce_flags->cdata = ($this->ze_other_ptr->ce_flags | \ZE::ZEND_ACC_FINAL);
            } else {
                $this->ze_other_ptr->ce_flags->cdata = ($this->ze_other_ptr->ce_flags & (~\ZE::ZEND_ACC_FINAL));
            }
        }

        /**
         * @inheritDoc
         * @return ZendClassConstant|\ReflectionClassConstant
         */
        public function getReflectionConstant($name): ZendClassConstant
        {
            $constantEntry = $this->constantsTable->find($name);
            if ($constantEntry === null) {
                return \ze_ffi()->zend_error(\E_WARNING, "Constant %s does not exist", $name);
            }

            $constantPtr = \ze_ffi()->cast('zend_class_constant *', $constantEntry->ptr());

            return ZendClassConstant::init_values($constantPtr, $name);
        }

        public function __debugInfo()
        {
            return [
                'name' => $this->getName(),
            ];
        }

        /**
         * Checks if the current class has a parent
         */
        private function hasParent(): bool
        {
            return $this->ze_other_ptr->parent_name !== null;
        }

        /**
         * Adds a low-level function(method) to the class
         *
         * @param string $methodName Method name to use
         * @param CData  $rawFunction zend_function instance
         * @param bool   $isPersistent Whether this method is persistent or not
         *
         * @return ZendMethod|\ReflectionMethod
         */
        private function initMethod(string $methodName, CData $rawFunction, bool $isPersistent = true): ZendMethod
        {
            $valueEntry = Zval::new(\ZE::IS_PTR, $rawFunction, $isPersistent);
            $this->methodTable->add(\strtolower($methodName), $valueEntry);
            $refMethod = ZendMethod::init_value($rawFunction);

            return $refMethod;
        }

        /**
         * Performs low-level initialization of fields
         *
         * @param CData $ce zend_class_entry
         */
        private function initLowLevel(CData $ce): void
        {
            $this->ze_other_ptr = $ce;
            $this->methodTable = HashTable::init_value(\ffi_ptr(($ce->function_table)));
            $this->propertiesTable = HashTable::init_value(\ffi_ptr($ce->properties_info));
            $this->constantsTable  = HashTable::init_value(\ffi_ptr($ce->constants_table));
            if (\IS_PHP8 && $ce->attributes !== null) {
                $this->attributesTable = HashTable::init_value(\ffi_ptr($ce->attributes));
            }
        }
    }
}
