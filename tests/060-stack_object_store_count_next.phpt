--TEST--
Check for Stack Object Store - Count & Next Handle
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

    public function getCount(): void
    {
        $currentCount = count($this->objectStore);
        var_dump(0 < $currentCount);
        // We cannot predict the size of objectStore, because it can reuse previously deleted slots
    }

    public function getFreeHandle(): void
    {
        // We can predict what will be the next handle of object
        $expectedHandle = $this->objectStore->list_head();
        $object         = new \stdClass();
        $objectHandle   = spl_object_id($object);
        $nextHandle     = $this->objectStore->list_head();

        var_dump($expectedHandle === $objectHandle);
        var_dump($expectedHandle !== $nextHandle);
    }

    public function run()
    {
        $this->getCount();
        $this->getFreeHandle();
    }
}

$test = new Entry();
$test->run();
--EXPECTF--
bool(true)
bool(true)
bool(true)
