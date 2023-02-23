--TEST--
Check for Stack Object Store - Warning
--SKIPIF--
<?php if (!extension_loaded("ffi")) print "skip"; ?>
--FILE--
<?php
require 'vendor/autoload.php';

use ZE\ZendObject;
use ZE\ZendObjectsStore;

class Entry
{
    private ZendObjectsStore $objectStore;

    public function __construct()
    {
        $this->objectStore = zend_object_store();
    }

    public function getOffsetUnset(): void
    {
        $id = spl_object_id($this);
        unset($this->objectStore[$id]);
    }

    public function getOffsetSet(): void
    {
        $id = spl_object_id($this);
        $this->objectStore[$id] = $this;
    }

    public function run()
    {
        $this->getOffsetUnset();
        $this->getOffsetSet();
    }
}

$test = new Entry();
$test->run();
--EXPECTF--
Warning: Object store is read-only structure in %s

Warning: Object store is read-only structure in %s
