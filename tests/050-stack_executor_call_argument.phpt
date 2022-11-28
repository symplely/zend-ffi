--TEST--
Check for Stack Executor - call_argument
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
    public function getArgument($argument)
    {
        $firstArgument = zend_executor()->call_argument(0);

        $firstPhpArgument = zval_native($firstArgument);
        var_dump($firstArgument instanceof Zval);
        var_dump($firstPhpArgument === $argument);
    }

    public function run()
    {
        $this->getArgument(false);
    }
}

$test = new Entry();
$test->run();
--EXPECT--
bool(true)
bool(true)
