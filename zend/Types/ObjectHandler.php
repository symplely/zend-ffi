<?php

declare(strict_types=1);

namespace ZE;

use FFI;
use FFI\CData;
use ZE\Zval;

if (!\class_exists('ObjectHandler')) {
    /**
     *```cpp
     * typedef struct _zend_object_handlers
     *{
     * int offset; // offset of real object header (usually zero)
     * // object handlers
     * zend_object_free_obj_t free_obj; // required
     * zend_object_dtor_obj_t dtor_obj; // required
     * zend_object_clone_obj_t clone_obj; // optional
     * zend_object_read_property_t read_property; // required
     * zend_object_write_property_t write_property; // required
     * zend_object_read_dimension_t read_dimension; // required
     * zend_object_write_dimension_t write_dimension; // required
     * zend_object_get_property_ptr_ptr_t get_property_ptr_ptr; // required
     * zend_object_get_t get; // optional
     * zend_object_set_t set; // optional
     * zend_object_has_property_t has_property; // required
     * zend_object_unset_property_t unset_property; // required
     * zend_object_has_dimension_t has_dimension; // required
     * zend_object_unset_dimension_t unset_dimension; // required
     * zend_object_get_properties_t get_properties; // required
     * zend_object_get_method_t get_method; // required
     * zend_object_call_method_t call_method; // optional
     * zend_object_get_constructor_t get_constructor; // required
     * zend_object_get_class_name_t get_class_name; // required
     * zend_object_compare_t compare_objects; // optional
     * zend_object_cast_t cast_object; // optional
     * zend_object_count_elements_t count_elements; // optional
     * zend_object_get_debug_info_t get_debug_info; // optional
     * zend_object_get_closure_t get_closure; // optional
     * zend_object_get_gc_t get_gc; // required
     * zend_object_do_operation_t do_operation; // optional
     * zend_object_compare_zvals_t compare; // optional
     * zend_object_get_properties_for_t get_properties_for; // optional
     *} zend_object_handlers;
     *```
     */
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
        protected CData $writeValue;

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
        private ?CData $rv;

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
            if (\IS_PHP74)
                Zval::init_value($this->object)->native_value($objectInstance);
            else
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
