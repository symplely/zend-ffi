--TEST--
Check for Stack Executor
--SKIPIF--
<?php if (!extension_loaded("ffi")) print "skip"; ?>
--FILE--
require 'vendor/autoload.php';

use FFI\CData;
use ZE\Zval;
use ZE\ZendOp;
use ZE\HashTable;
use ZE\ZendExecutor;

class Entry
{
    public function executor()
    {
        $executionData = zend_executor();
        var_dump($executionData instanceof ZendExecutor);

        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
        var_dump($trace[0]['function'] === $executionData->func()->getName());

        $symTable = zend_executor()->symbol_table();
        var_dump($symTable instanceof HashTable);
    }

    public function getVariable()
    {
        $expected = microtime(true);
        // $expected will be the first temporary variable in the stack, so index will be 0
        $value = ZendExecutor::init()->call_variable_number(0);
        var_dump($value instanceof CData);

        // Let's check if this value equals to our original $expected
        $zval = zend_value($value);
        $zval->native_value($return);
        var_dump($expected === $return);
    }

    public function getArguments($arg1 = null, $arg2 = null, $arg3 = null)
    {
        $engineArguments = zend_executor()->call_arguments();
        $receivedArguments = [];
        foreach ($engineArguments as $zvalValue) {
            // We can collect original PHP values from the Core one-by-one
            $zvalValue->native_value($value);
            $receivedArguments[] = $value;
            unset($value);
        }
        var_dump(func_get_args() === $receivedArguments);

        $engineArguments = zend_executor()->number_arguments();
        $expectedNumber  = func_num_args();
        var_dump($expectedNumber == $engineArguments);
    }

    public function getArgument($argument)
    {
        $firstArgument = zend_executor()->call_argument(0);

        $firstPhpArgument = zval_native($firstArgument);
        var_dump($firstArgument instanceof Zval);
        var_dump($firstPhpArgument === $argument);
    }

    public function getOpline()
    {
        $opline = zend_op();
        var_dump(__LINE__ - 1 === $opline->lineno());
        var_dump($opline instanceof ZendOp);
    }

    public function getThis()
    {
        $thisValue = zend_executor()->This();
        $thisValue->native_value($instance);
        var_dump($this === $instance);

        // Just for fun: we can do crazy things like changing $this in current stack frame
        $thisValue->change_value(new \stdClass);
        var_dump($this instanceof \stdClass);
    }

    public function getFunction()
    {
        $zvalFunction = zend_executor()->func();
        var_dump(__FUNCTION__ === $zvalFunction->getName());
    }

    public function getReturnValue()
    {
        $zval = zend_executor()->return_value();
        $s = zval_native($zval);
        var_dump(!isset($s));
    }

    public function run()
    {
        $this->executor();
        $this->getVariable();
        $this->getArguments(1, ['a', false], [null, new \stdClass, 42.0]);
        $this->getArgument(false);
        $this->getOpline();
        $this->getThis();
        $this->getFunction();
        $this->getReturnValue();
    }
}

$test = new Entry();
$test->run();
--EXPECT--
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
