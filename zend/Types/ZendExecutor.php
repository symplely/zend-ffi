<?php

declare(strict_types=1);

namespace ZE;

use FFI\CData;
use ZE\ZendOp;
use ZE\HashTable;
use ZE\ZendMethod;
use ZE\ZendFunction;
use ZE\ZendObjectsStore;

if (!\class_exists('ZendExecutor')) {
    /**
     * `ZendExecutor` provides information about current stack frame
     *```c++
     * typedef struct _zend_execute_data {
     *   const zend_op       *opline;           // executed opline
     *   zend_execute_data   *call;             // current call
     *   zval                *return_value;
     *   zend_function       *func;             // executed function
     *   zval                 This;             // this + call_info + num_args
     *   zend_execute_data   *prev_execute_data;
     *   zend_array          *symbol_table;
     *   void               **run_time_cache;   // cache op_array->run_time_cache
     * };
     *```
     */
    final class ZendExecutor extends \ZE
    {
        /**  This should be equal to ZEND_MM_ALIGNMENT */
        const MM_ALIGNMENT = 8;

        protected $isZval = false;

        /**
         * Represents `EG(executor_globals)` _macro_.
         *- Trick here is to look at internal structures and steal pointer to our value from current frame
         *
         * @return self
         */
        public static function init(): ZendExecutor
        {
            $value = static::executor_globals();
            return static::init_value($value->current_execute_data->prev_execute_data)
                ->with_current($value->current_execute_data);
        }


        public static function class_table(): HashTable
        {
            return HashTable::init_value(static::executor_globals()->class_table);
        }

        public static function function_table(): HashTable
        {
            return HashTable::init_value(static::executor_globals()->function_table);
        }

        public static function objects_store(): ZendObjectsStore
        {
            return ZendObjectsStore::init_value(static::executor_globals()->objects_store);
        }

        /**
         * Returns the previous execution data entry (aka stack)
         */
        public function previous_state(): ZendExecutor
        {
            if ($this->ze_other_ptr->prev_execute_data === null) {
                return \ze_ffi()->zend_error(\E_WARNING, 'There is no previous execution data.');
            }

            return static::init_value($this->ze_other_ptr->prev_execute_data)
                ->with_current($this->ze_other->prev_execute_data);
        }

        public function current_state(): ZendExecutor
        {
            return static::init_value($this->ze_other)
                ->with_current($this->ze_other->prev_execute_data);
        }

        /**
         * Returns the "return value"
         */
        public function return_value(): Zval
        {
            if (!\is_null($this->ze_other_ptr->return_value)) {
                return Zval::init_value($this->ze_other_ptr->return_value);
            }

            return Zval::init();
        }

        public function with_current(CData $ptr)
        {
            $this->ze_other = $ptr;

            return $this;
        }

        /**
         * Returns the current function or method
         *
         * @return ZendFunction
         */
        public function func(): ZendFunction
        {
            if ($this->ze_other_ptr->func === null) {
                return \ze_ffi()->zend_error(\E_WARNING, 'Function creation is not available in the current context');
            }

            if ($this->ze_other_ptr->func->common->scope === null) {
                $func = ZendFunction::init_value($this->ze_other_ptr->func);
            } else {
                $func = ZendMethod::init_value($this->ze_other_ptr->func);
            }

            return $func;
        }

        /**
         * Returns an execution state with scope, variables, etc.
         * - `zend_execute_data` provides information about current stack frame
         *
         * @return CData zend_execute_data
         *
         * @property zend_op* $opline;          executed opline
         * @property zend_execute_data* $call;  current call
         * @property zval* $return_value;
         * @property zend_function* $func;      executed function
         * @property zval $This;                $This->u2->num_args
         * @property zend_execute_data* $prev_execute_data;
         * @property zend_array* $symbol_table;
         * @property void** $run_time_cache;     cache op_array->run_time_cache
         */
        public function execution_state(): CData
        {
            return $this->ze_other_ptr;
        }

        public function number_arguments(): int
        {
            return $this->ze_other_ptr->This->u2->num_args;
        }

        /**
         * Returns call variable from the stack by number.
         * Represents `ZEND_CALL_VAR_NUM()` _macro_.
         *
         * @param int $variableNum Variable number - a calls zend_execute_data
         *
         * @return CData zval* pointer
         */
        public function call_variable_number(int $variableNum): CData
        {
            // (((zval*)(call)) + (ZEND_CALL_FRAME_SLOT + ((int)(n))))
            $pointer = \ze_ffi()->cast('zval *', $this->ze_other_ptr);

            return $pointer + static::call_frame_slot() + $variableNum;
        }

        /**
         * Returns call variable from the stack.
         * Represents `ZEND_CALL_VAR()` _macro_.
         *
         * @param int $variableOffset Variable offset
         *
         * @return CData zval* pointer
         */
        public function call_variable(int $variableOffset): CData
        {
            // ((zval*)(((char*)(call)) + ((int)(n))))
            return \ze_ffi()->cast(
                'zval *',
                (\ze_ffi()->cast('char *', $this->ze_other_ptr) + $variableOffset)
            );
        }

        /**
         * Returns the argument by it's index.
         * Represents `ZEND_CALL_ARG()` _macro_.
         *
         * Argument index is starting from 0.
         */
        public function call_argument(int $argumentIndex): Zval
        {
            if ($argumentIndex >= $this->number_arguments())
                return \ze_ffi()->zend_error(\E_WARNING, "Argument index is greater than available arguments");

            $pointer = $this->call_variable_number($argumentIndex);
            return Zval::init_value($pointer);
        }

        /**
         * Returns execution arguments as array of values
         *
         * @return Zval[]
         */
        public function call_arguments(): array
        {
            $arguments = [];
            $totalArguments = $this->number_arguments();
            for ($index = 0; $index < $totalArguments; $index++) {
                $arguments[] = $this->call_argument($index);
            }

            return $arguments;
        }

        /**
         * Returns the current object scope
         *
         * This contains following: this + call_info + num_args
         */
        public function This(): Zval
        {
            return Zval::init_value(\ffi_ptr($this->ze_other_ptr->This));
        }

        /**
         * Set a new fake scope and returns previous value (to restore it later)
         *
         * @return CData|null
         */
        public function fake_scope(?CData $newScope): ?CData
        {
            $oldScope = $this->ze_other_ptr->fake_scope;
            $this->ze_other_ptr->fake_scope = $newScope;

            return $oldScope;
        }

        /**
         * Returns the current symbol table.
         *         *
         * @return HashTable
         */
        public function symbol_table(): HashTable
        {
            return HashTable::init_value($this->ze_other_ptr->symbol_table);
        }

        /**
         * Returns the currently executed opline
         */
        public function opline(): ZendOp
        {
            return ZendOp::init($this->ze_other_ptr->opline, $this);
        }

        /**
         * Moves current opline pointer to the next one
         *
         * Use it only within opcode handlers!
         */
        public function nextOpline(): void
        {
            $this->ze_other_ptr->opline++;
        }

        /**
         * Calculates the call frame slot size.
         * Represents `ZEND_CALL_FRAME_SLOT()` _macro_.
         */
        private static function call_frame_slot(): int
        {
            static $slotSize;
            if ($slotSize === null) {
                $alignedSizeOfExecuteData = static::aligned_size(\FFI::sizeof(\ze_ffi()->type('zend_execute_data')));
                $alignedSizeOfZval = static::aligned_size(\FFI::sizeof(\ze_ffi()->type('zval')));

                $slotSize = \intdiv(($alignedSizeOfExecuteData + $alignedSizeOfZval) - 1, $alignedSizeOfZval);
            }

            return $slotSize;
        }
    }
}
