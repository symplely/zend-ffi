--TEST--
Check for Stack Object Store - OffsetGet
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

    public function run()
    {
        $this->getOffsetGet();
    }
}

$test = new Entry();
$test->run();
--EXPECTF--
bool(true)
bool(true)
bool(true)
