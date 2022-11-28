--TEST--
Check for Stack Executor - call_arguments
--SKIPIF--
<?php if (!extension_loaded("ffi")) print "skip"; ?>
--FILE--
<?php
require 'vendor/autoload.php';

use FFI\CData;
use ZE\Zval;
use ZE\ZendOp;
use ZE\HashTable;
use ZE\ZendExecutor;

class Entry
{
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

    public function run()
    {
        $this->getArguments(1, ['a', false], [null, new \stdClass, 42.0]);
    }
}

$test = new Entry();
$test->run();
--EXPECT--
bool(true)
bool(true)
