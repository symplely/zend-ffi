<?php

declare(strict_types=1);

namespace ZE;

use FFI;
use FFI\CData;
use ZE\Hook\CreateObject;

if (!\class_exists('ObjectHandler')) {
    abstract class ObjectHandler
    {
        protected const HOOK_FIELD = 'unknown';

        /**
         * Contains a top-level structure that contains a field with hook
         *
         * @var CData|FFI Either raw C structure or global FFI object itself
         */
        private $c_struct;

        /**
         * Interface type that is implemented
         */
        protected CData $interfaceType;

        /**
         * Class that implements interface
         */
        protected CData $classType;

        /**
         * Custom user handler
         */
        protected \Closure $userHandler;

        /**
         * Holds an original handler (if present)
         */
        protected ?CData $originalHandler;

        /**
         * Object instance to perform casting
         */
        protected CData $object;

        /**
         * Holds a return value
         */
        protected CData $returnValue;

        /**
         * Value to write
         */
        protected CData $value;

        /**
         * Calling reason
         *
         * @see zend_prop_purpose enumeration
         */
        protected int $purpose;

        /**
         * Cast type
         */
        protected int $type;

        /**
         * Operation opcode
         */
        protected int $opCode;

        /**
         * First operand
         */
        protected CData $op1;

        /**
         * Second operand
         */
        protected CData $op2;

        /**
         * Internal pointer of retval (for native callback only)
         */
        protected ?CData $rv;

        /**
         * @param CData|mixed ...$c_args
         * @return mixed|void
         */
        public function handle(...$c_args)
        {
        }

        /**
         * @return mixed|void
         */
        public function continue()
        {
        }

        public function __construct(\Closure $userHandler, $c_struct)
        {
            if (!($c_struct instanceof FFI || $c_struct instanceof CData))
                return \ze_ffi()->zend_error(\E_WARNING, 'Invalid container');

            $this->userHandler = $userHandler;
            $this->c_struct = $c_struct;
            $this->originalHandler = $c_struct->{static::HOOK_FIELD};
        }

        /**
         * Performs low-level initialization of object during new instances creation
         *
         * @param CreateObject $hook Hook instance that provides proceed() and class_type() method
         *
         * @return CData Pointer to the zend_object instance
         */
        public static function __init(CreateObject $hook): CData
        {
            return $hook->continue();
        }

        /**
         * Performs installation of current hook
         */
        final public function install(): void
        {
            $this->c_struct->{static::HOOK_FIELD} = \closure_from($this, 'handle');
        }

        /**
         * Returns an object instance
         */
        public function object(): object
        {
            $objectInstance = ZendObject::init_value($this->object)->native_value();

            return $objectInstance;
        }

        /**
         * Returns `result` of execution
         */
        public function result()
        {
            Zval::init_value($this->returnValue)->native_value($result);

            return $result;
        }

        /**
         * Returns an opcode
         */
        public function opcode(): int
        {
            return $this->opCode;
        }

        /**
         * Returns `value` of first operand - op1
         */
        public function op1()
        {
            Zval::init_value($this->op1)->native_value($value);

            return $value;
        }

        /**
         * Returns `value` of second operand - op2
         */
        public function op2()
        {
            Zval::init_value($this->op2)->native_value($value);

            return $value;
        }

        /**
         * Checks if an original handler is present to call it later with proceed
         */
        final public function has_original(): bool
        {
            return $this->originalHandler !== null;
        }

        /**
         * Automatic hook restore, this destructor ensures that there won't be any dead C pointers to PHP structures
         */
        final public function __destruct()
        {
            $this->c_struct->{static::HOOK_FIELD} = $this->originalHandler;
        }

        /**
         * Internal CData fields could result in segfaults, so let's hide everything
         */
        final public function __debugInfo(): array
        {
            return [
                'userHandler' => $this->userHandler
            ];
        }
    }
}
