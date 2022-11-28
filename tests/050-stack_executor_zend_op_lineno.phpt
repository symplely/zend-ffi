--TEST--
Check for Stack Executor - zend_op lineno
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
    public function getOpline()
    {
        $opline = zend_op();
        var_dump(__LINE__ - 1 === $opline->lineno());
        var_dump($opline instanceof ZendOp);
    }

    public function run()
    {
        $this->getOpline();
    }
}

$test = new Entry();
$test->run();
--EXPECT--
bool(true)
bool(true)
