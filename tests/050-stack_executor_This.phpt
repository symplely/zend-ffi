--TEST--
Check for Stack Executor -This
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
    public function getThis()
    {
        $thisValue = zend_executor()->This();
        $thisValue->native_value($instance);
        var_dump($this === $instance);

        // Just for fun: we can do crazy things like changing $this in current stack frame
        $thisValue->change_value(new \stdClass);
        var_dump($this instanceof \stdClass);
    }

    public function run()
    {
        $this->getThis();
    }
}

$test = new Entry();
$test->run();
--EXPECT--
bool(true)
bool(true)
