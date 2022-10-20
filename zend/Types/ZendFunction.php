<?php

declare(strict_types=1);

namespace ZE;

use FFI\CData;
use ZE\Zval;
use ZE\ZendOp;
use ZE\ZendClosure;

if (!\class_exists('ZendFunction')) {
    /**
     * Class `ZendFunction` represents PHP instance of a **internal/userland** function or method.
     *
     *```c++
     * union _zend_function {
     *	zend_uchar  type;	// MUST be the first element of this struct!
     *	uint32_t    quick_arg_flags;
     *
     *	struct {
     *		zend_uchar  type;  /// never used
     *		zend_uchar  arg_flags[3]; // bitset of arg_info.pass_by_reference
     *		uint32_t    fn_flags;
     *		zend_string *function_name;
     *		zend_class_entry    *scope;
     *		zend_function   *prototype;
     *		uint32_t    num_args;
     *		uint32_t    required_num_args;
     *		zend_arg_info   *arg_info;  // index -1 represents the return value info, if any *
     *		HashTable   *attributes; // Only for PHP 8+
     *	} common;
     *
     *	zend_op_array   op_array;
     *	zend_internal_function  internal_function;
     *};
     *```
     * @property \ReflectionFunction $reflection
     */
    class ZendFunction extends \ZE
    {
        protected $isZval = false;

        /**
         * @return ZendFunction|\ReflectionFunction
         */
        public static function init(string ...$arguments): self
        {
            $functionName = \reset($arguments);

            /** @var Zval */
            $zvalFunction = HashTable::init_value(static::executor_globals()->function_table)
                ->find(\strtolower($functionName));

            if ($zvalFunction === null) {
                return \ze_ffi()->zend_error(\E_WARNING, "Function %s should be in the engine.", $functionName);
            }

            $zendFunc = self::init_value($zvalFunction->func());
            $zendFunc->addReflection($functionName);

            return $zendFunc;
        }

        /**
         * @return ZendFunction|\ReflectionFunction
         */
        public static function init_value(CData $ptr): self
        {
            if ($ptr->type === \ZE::ZEND_INTERNAL_FUNCTION) {
                $functionPtr = $ptr->function_name;
            } else {
                $functionPtr = $ptr->common->function_name;
            }

            $function = (new \ReflectionClass(static::class))->newInstanceWithoutConstructor();
            $function->update($ptr);

            if ($functionPtr !== null) {
                $string = ZendString::init_value($functionPtr);
                $function->addReflection($string->value());
            }

            return $function;
        }

        /**
         * @return ZendFunction|\ReflectionFunction
         */
        public function addReflection(string ...$arguments): self
        {
            $this->reflection = new \ReflectionFunction(\reset($arguments));

            return $this;
        }

        /**
         * Declares method as deprecated/non-deprecated
         */
        public function deprecated(bool $isDeprecated = true): void
        {
            if ($isDeprecated) {
                $this->getPtr()->fn_flags |= \ZE::ZEND_ACC_DEPRECATED;
            } else {
                $this->getPtr()->fn_flags &= (~\ZE::ZEND_ACC_DEPRECATED);
            }
        }

        /**
         * Declares method as variadic/non-variadic
         */
        public function variadic(bool $isVariadic = true): void
        {
            if ($isVariadic) {
                $this->getPtr()->fn_flags |= \ZE::ZEND_ACC_VARIADIC;
            } else {
                $this->getPtr()->fn_flags &= (~\ZE::ZEND_ACC_VARIADIC);
            }
        }

        /**
         * Declares method as generator/non-generator
         */
        public function generator(bool $isGenerator = true): void
        {
            if ($isGenerator) {
                $this->getPtr()->fn_flags |= \ZE::ZEND_ACC_GENERATOR;
            } else {
                $this->getPtr()->fn_flags &= (~\ZE::ZEND_ACC_GENERATOR);
            }
        }

        /**
         * Redefines an existing method in the class with closure
         * - Note: Doesn't work _correctly_ for **userland** functions, if **php.ini** is `opcache.enable_cli=1`.
         */
        public function redefine(\Closure $newCode): void
        {
            $this->checkClosure($newCode);
            if (!$this->reflection->isInternal()) {
                $newCodeEntry = ZendClosure::init($newCode)->func();

                // Copy only common op_array part from original one to keep name, scope, etc
                \FFI::memcpy($newCodeEntry, $this->ze_other_ptr[0], \FFI::sizeof($newCodeEntry->common));

                // Replace original method with redefined closure
                \FFI::memcpy($this->ze_other_ptr, \ffi_ptr($newCodeEntry), \FFI::sizeof($newCodeEntry));
            } else {
                // For internal function we can simply adjust a handler
                $this->ze_other_ptr->handler = function (CData $executeData, CData $returnValue) use ($newCode): void {
                    $rawValue = Zval::init_value($returnValue);
                    $stackTrace = \debug_backtrace(0, 2);
                    $result = $newCode(...$stackTrace[1]['args']);
                    $rawValue->change_value($result);
                };
            }
        }

        public function isUserDefined(): bool
        {
            return (bool) ($this->ze_other_ptr->type & \ZE::ZEND_USER_FUNCTION);
        }

        /**
         * Returns the iterable generator of opcodes for this function
         *
         * @return iterable|ZendOp[]
         */
        public function opcodes(): iterable
        {
            if (!$this->isUserDefined()) {
                return \ze_ffi()->zend_error(\E_WARNING, 'Opcodes are available only for user-defined functions');
            }

            $opCodes = [];
            $opcodeIndex = 0;
            $totalOpcodes = $this->ze_other_ptr->op_array->last;
            while ($opcodeIndex < $totalOpcodes) {
                $opCode = ZendOp::init(
                    \ffi_ptr($this->ze_other_ptr->op_array->opcodes[$opcodeIndex++])
                );

                $opCodes[] = $opCode;
            }

            return $opCodes;
        }

        /**
         * Returns the total number of literals
         */
        public function number_literals(): int
        {
            if (!$this->isUserDefined()) {
                return \ze_ffi()->zend_error(\E_WARNING, 'Literals are available only for user-defined functions');
            }

            return $this->ze_other_ptr->op_array->last_literal;
        }

        /**
         * Returns one single literal's value by it's index
         *
         * @param int $index
         *
         * @return Zval
         */
        public function literal(int $index): Zval
        {
            if (!$this->isUserDefined()) {
                return \ze_ffi()->zend_error(\E_WARNING, 'Literals are available only for user-defined functions');
            }

            $lastLiteral = $this->ze_other_ptr->op_array->last_literal;
            if ($index > $lastLiteral) {
                return \ze_ffi()->zend_error(\E_WARNING, "Literal index %d is out of bounds, last is %d", $index, $lastLiteral);
            }

            $literal = $this->ze_other_ptr->op_array->literals[$index];

            return Zval::init_value($literal);
        }

        /**
         * Returns list of literals, associated with this entry
         *
         * @return Zval[]
         */
        public function literals(): iterable
        {
            if (!$this->isUserDefined()) {
                return \ze_ffi()->zend_error(\E_WARNING, 'Literals are available only for user-defined functions');
            }

            $literalValueGenerator = function () {
                $literalIndex  = 0;
                $totalLiterals = $this->ze_other_ptr->op_array->last_literal;
                while ($literalIndex < $totalLiterals) {
                    $item = $this->ze_other_ptr->op_array->literals[$literalIndex];
                    $literalIndex++;
                    yield Zval::init_value($item);
                }
            };

            return $literalValueGenerator();
        }

        public function __debugInfo(): array
        {
            return [
                'name' => $this->reflection->getName(),
            ];
        }

        /**
         * Checks if the given closure signature is compatible to original one (number of arguments, type hints, etc)
         *
         * @throws \ReflectionException if closure signature is not compatible with current function/method
         */
        private function checkClosure(\Closure $newCode): void
        {
            /** @var \ReflectionFunction[] $reflectionPair */
            $reflectionPair = [$this, new \ReflectionFunction($newCode)];
            $signatures = [];
            foreach ($reflectionPair as $index => $reflectionFunction) {
                $signature = 'function ';
                if ($reflectionFunction->returnsReference()) {
                    $signature .= '&';
                }

                $signature .= '(';
                $parameters = [];
                foreach ($reflectionFunction->getParameters() as $reflectionParameter) {
                    $parameter = '';
                    if ($reflectionParameter->hasType()) {
                        $type = $reflectionParameter->getType();
                        if ($type->allowsNull()) {
                            $parameter .= '?';
                        }

                        $parameter .= $type->getName() . ' ';
                    }

                    if ($reflectionParameter->isPassedByReference()) {
                        $parameter .= '&';
                    }

                    if ($reflectionParameter->isVariadic()) {
                        $parameter .= '...';
                    }

                    $parameter .= '$';
                    $parameter .= $reflectionParameter->getName();
                    $parameters[] = $parameter;
                }

                $signature .= \join(', ', $parameters);
                $signature .= ')';
                if ($reflectionFunction->hasReturnType()) {
                    $signature .= ': ';
                    $type = $reflectionFunction->getReturnType();
                    if ($type->allowsNull()) {
                        $signature .= '?';
                    }

                    $signature .= $type->getName();
                }

                $signatures[] = $signature;
            }

            if ($signatures[0] !== $signatures[1]) {
                throw new \ReflectionException(
                    'Given function signature: "' . $signatures[1] . '"' .
                        ' should be compatible with original "' . $signatures[0] . '"'
                );
            }
        }

        /**
         * Returns a pointer to the common structure (to work natively with zend_function and zend_internal_function)
         */
        protected function getPtr(): CData
        {
            // For zend_internal_function we have same fields directly in current structure
            if ($this->reflection->isInternal())
                return $this->ze_other_ptr;

            // zend_function uses "common" struct to store all important fields
            return $this->ze_other_ptr->common;
        }

        /**
         * Returns the hash key for function or method
         */
        protected function getHash(): string
        {
            return $this->reflection->name;
        }
    }
}
