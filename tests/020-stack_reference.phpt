--TEST--
Check for Stack Reference
--SKIPIF--
<?php if (!extension_loaded("ffi")) print "skip"; ?>
--FILE--
<?php
require 'vendor/autoload.php';

$value     = 'some';
$reference = zend_reference($value);
var_dump($reference);

// At that point we will get a Zval instance of original variable
$refValue = $reference->internal_value();
var_dump($refValue instanceof \ZE\Zval);

$refValue->native_value($originalValue);
var_dump($value === $originalValue);
--EXPECTF--
object(ZE\ZendReference)#%d (2) {
  ["refcount"]=>
  int(1)
  ["value"]=>
  object(ZE\Zval)#%d (2) {
    ["type"]=>
    string(%d) "IS_INTERNED_STRING_EX"
    ["value"]=>
    string(%d) "some"
  }
}
bool(true)
bool(true)
