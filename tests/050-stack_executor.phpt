--TEST--
Check for Stack Executor
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
    public function executor()
    {
        $executionData = zend_executor();
        var_dump($executionData instanceof ZendExecutor);

        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
        var_dump($trace[0]['function'] === $executionData->func()->getName());

        $symTable = zend_executor()->symbol_table();
        var_dump($symTable instanceof HashTable);
    }

    public function run()
    {
        $this->executor();
    }
}

$test = new Entry();
$test->run();
--EXPECT--
bool(true)
bool(true)
bool(true)
