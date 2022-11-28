--TEST--
Check for Stack Executor - call_variable_number
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

    public function run()
    {
        $this->getVariable();
    }
}

$test = new Entry();
$test->run();
--EXPECT--
bool(true)
bool(true)
