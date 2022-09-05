--TEST--
Check for Stack Object Store
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

    public function getOffsetGet(): void
    {
        $id = spl_object_id($this);
        $objectEntry = $this->objectStore->offsetGet($id);
        var_dump($objectEntry instanceof ZendObject);
        var_dump($this === $objectEntry->native_value());

        // Now let's create new object and check that it's still accessible
        $newObject = new \stdClass();
        $id = spl_object_id($newObject);
        $objectEntry = $this->objectStore->offsetGet($id);
        var_dump($newObject === $objectEntry->native_value());
    }

    public function getOffsetExists(): void
    {
        $id = spl_object_id($this);
        var_dump($this->objectStore->offsetExists($id) === true);
        var_dump(isset($this->objectStore[$id]) === true);
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
        $this->getOffsetUnset();
        $this->getOffsetSet();
        $this->getOffsetGet();
        $this->getOffsetExists(false);
        $this->getCount();
        $this->getFreeHandle();
    }
}

$test = new Entry();
$test->run();
--EXPECTF--
Warning: Object store is read-only structure in %s

Warning: Object store is read-only structure in %s
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
