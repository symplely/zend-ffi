--TEST--
Check for Stack Object Store - OffsetExists
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

    public function getOffsetExists(): void
    {
        $id = spl_object_id($this);
        var_dump($this->objectStore->offsetExists($id) === true);
        var_dump(isset($this->objectStore[$id]) === true);
    }

    public function run()
    {
        $this->getOffsetExists();
    }
}

$test = new Entry();
$test->run();
--EXPECTF--
bool(true)
bool(true)
