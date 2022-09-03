--TEST--
Check for Stack Object
--SKIPIF--
<?php if (!extension_loaded("ffi")) print "skip"; ?>
--FILE--
require 'vendor/autoload.php';

$instance = new \RuntimeException('Test');
$zend = zend_object($instance);
$class = $zend->class_entry();
var_dump(\RuntimeException::class === $class->getName());

$zend = zend_object($instance);
$zend->change(\Exception::class);
$className = get_class($instance);
var_dump(\Exception::class === $className);

$objectHandle = spl_object_id($instance);
var_dump($objectHandle === $zend->handle());

$zend = zend_object($instance);
$originalHandle = spl_object_id($instance);
$entryHandle = spl_object_id($zend);
// We just update a handle for internal object to be the same as $objectEntry itself
$zend->handle($entryHandle);

var_dump(spl_object_id($zend) === spl_object_id($instance));
var_dump($zend != $instance);

// This is required to prevent a ZEND_ASSERT(EG(objects_store).object_buckets != NULL) during shutdown
$zend->handle($originalHandle);
--EXPECT--
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
