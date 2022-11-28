--TEST--
Check for Stack Executor - func
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
    public function getFunction()
    {
        $zvalFunction = zend_executor()->func();
        var_dump(__FUNCTION__ === $zvalFunction->getName());
    }

    public function run()
    {
        $this->getFunction();
    }
}

$test = new Entry();
$test->run();
--EXPECT--
bool(true)
