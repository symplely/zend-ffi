<?php

declare(strict_types=1);

namespace ZE;

use FFI\CData;
use ZE\Zval;
use ZE\ZendExecutor;

if (!\class_exists('ZendOp')) {
    /**
     * Class `ZendOp` represents one `Op line` operation that should be performed by the PHP engine.
     *```c++
     * struct _zend_op {
     *   const void *handler;
     *   znode_op op1;
     *   znode_op op2;
     *   znode_op result;
     *   uint32_t extended_value;
     *   uint32_t lineno;
     *   zend_uchar opcode;         // uint8_t - PHP 8.3
     *   zend_uchar op1_type;       // uint8_t - PHP 8.3
     *   zend_uchar op2_type;       // uint8_t - PHP 8.3
     *   zend_uchar result_type;    // uint8_t - PHP 8.3
     * };
     *```
     */
    final class ZendOp extends \ZE
    {
        /**
         * Unused operand
         */
        public const IS_UNUSED = 0;

        /**
         * This opcode node type is used for literal values in PHP code.
         *
         * For example, the integer literal 1 or string literal 'Hello, World!' will both be of this type.
         */
        public const IS_CONST = (1 << 0);

        /**
         * This opcode node type is used for temporary variables.
         *
         * These are typically used to store an intermediate result of a larger operation (making them short-lived).
         * They can be an IS_TYPE_REFCOUNTED type (as of PHP 7), but not an IS_REFERENCE type
         * (since temporary values cannot be used as references).
         *
         * For example, the return value of $a++ will be of this type.
         */
        public const IS_TMP_VAR = (1 << 1);

        /**
         * This opcode node type is used for complex variables in PHP code.
         *
         * For example, the variable $obj->a is considered to be a complex variable, however the variable $a is not
         * (it is instead an IS_CV type).
         */
        public const IS_VAR = (1 << 2);

        /**
         * This opcode node type is used for simple variables in PHP code.
         *
         * For example, the variable $a is considered to be a simple variable,
         * however the variable $obj->a is not (it is instead an IS_VAR type).
         */
        public const IS_CV = (1 << 3);

        protected $isZval = false;
        private ?ZendExecutor $context;

        protected function __construct(CData $opline, ZendExecutor $context = null)
        {
            $this->ze_other_ptr  = $opline;
            $this->context = $context;
        }

        public static function init(CData $opline, ZendExecutor $execute_data = null): self
        {
            return new self($opline, $execute_data);
        }

        /**
         * Returns a raw pointer to the opcode handler
         */
        public function handler(): CData
        {
            return $this->ze_other_ptr->handler;
        }

        public function op1_type(): int
        {
            return $this->ze_other_ptr->op1_type;
        }

        public function op2_type(): int
        {
            return $this->ze_other_ptr->op2_type;
        }

        public function op1(): ?Zval
        {
            return $this->get_zval_ptr($this->ze_other_ptr->op1, $this->ze_other_ptr->op1_type);
        }

        public function op2(): ?Zval
        {
            return $this->get_zval_ptr($this->ze_other_ptr->op2, $this->ze_other_ptr->op2_type);
        }

        public function result(): ?Zval
        {
            return $this->get_zval_ptr($this->ze_other_ptr->result, $this->ze_other_ptr->result_type);
        }

        /**
         * Returns a defined code for this entry
         */
        public function opcode(): int
        {
            return $this->ze_other_ptr->opcode;
        }

        /**
         * Directly replace an internal code with another one.
         *
         * @param int $newCode
         * @internal
         */
        public function replace(int $newCode): void
        {
            $this->ze_other_ptr->opcode->cdata = $newCode;
        }

        /**
         * Returns user-friendly name of the opCode
         */
        public function get_name(): string
        {
            return OpCode::name($this->ze_other_ptr->opcode);
        }

        /**
         * Returns the line in the code for which this opCode was generated, or
         * sets a new line for this entry.
         *
         * @param int $newLine New line in the file
         * @return int|void
         * @internal
         */
        public function lineno(int $newLine = null)
        {
            if (\is_null($newLine))
                return $this->ze_other_ptr->lineno;

            $this->ze_other_ptr->lineno = $newLine;
        }

        /**
         * Returns the type name of operand
         *
         * @param int $opType Integer value of opType
         */
        public static function type_name(int $opType): string
        {
            static $opTypeNames;
            if (!isset($opTypeNames)) {
                $opTypeNames = \array_flip((new \ReflectionClass(self::class))->getConstants());
            }

            return $opTypeNames[$opType] ?? 'UNKNOWN';
        }

        /**
         * Returns a user-friendly representation of opCode line
         */
        public function __debugInfo(): array
        {
            $humanCode   = $this->get_name();
            $op1TypeName = self::type_name($this->ze_other_ptr->op1_type);
            $op2TypeName = self::type_name($this->ze_other_ptr->op2_type);
            $resTypeName = self::type_name($this->ze_other_ptr->result_type);

            return [
                $humanCode => [
                    'op1'    => [$op1TypeName => $this->op1()],
                    'op2'    => [$op2TypeName => $this->op2()],
                    'result' => [$resTypeName => $this->result()],
                    'line'   => $this->lineno()
                ]
            ];
        }

        /**
         * Represents `zend_get_zval_ptr()`, returns a pointer to value for given op_node and it's type.
         *
         * @param CData $node Instance of op1/op2/result node
         * @param int $opType operation code type, eg IS_CONST, IS_CV...
         *
         * @return Zval|null Extracted value or null, if value could not be resolved (eg. not in runtime)
         */
        private function get_zval_ptr(CData $node, int $opType): ?Zval
        {
            $zend_free_op = \IS_PHP74 ? \ze_ffi()->cast('zend_free_op*', Zval::init()()) : null;
            $zval = \ze_ffi()->zend_get_zval_ptr(
                $this->ze_other_ptr,
                $opType,
                \ffi_ptr($node),
                $this->context->execution_state(),
                $zend_free_op,
                0
            );

            return \is_null($zval) ? $this->get_zval_ptr_native($node, $opType) : \zend_value($zval);
        }

        private function get_zval_ptr_native(CData $node, int $opType): ?Zval
        {
            $pointer = null;

            switch ($opType) {
                case self::IS_CONST:
                    $pointer = self::runtime_constant($this->ze_other_ptr, $node);
                    break;
                case self::IS_TMP_VAR:
                case self::IS_VAR:
                case self::IS_CV:
                case self::IS_UNUSED: // For some opcodes IS_UNUSED still used, in most cases it points to an IS_UNDEF value
                    // All these types requires context to be present, otherwise we can't resolve such nodes
                    if (isset($this->context)) {
                        $pointer = $this->context->call_variable($node->var);
                    }

                    break;
                default:
                    return \ze_ffi()->zend_error(\E_WARNING, 'Received invalid opcode type: %d' . $opType);
            }


            return isset($pointer) ? \zend_value($pointer) : null;
        }

        /**
         * Returns value for a runtime-constant with IS_CONST type
         *
         * @see zend_compile.h:RT_CONSTANT macro definition
         *
         * @return CData zval* pointer
         */
        private static function runtime_constant(CData $opline, CData $node): CData
        {
            // ((zval*)(((char*)(opline)) + (int32_t)(node).constant))
            $pointer  = \FFI::cast('char *', $opline) + $node->constant;
            $value    = \ze_ffi()->cast('zval *', $pointer);

            return $value;
        }
    }
}
