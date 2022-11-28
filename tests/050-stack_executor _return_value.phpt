--TEST--
Check for Stack Executor - return_value
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
    public function getReturnValue()
    {
        $zval = zend_executor()->return_value();
        $s = zval_native($zval);
        var_dump(!isset($s));
    }

    public function run()
    {
        $this->getReturnValue();
    }
}

$test = new Entry();
$test->run();
--EXPECT--
bool(true)
