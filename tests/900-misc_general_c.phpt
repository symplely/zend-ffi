--TEST--
Check for Misc & General C
--SKIPIF--
<?php if (!extension_loaded("ffi")) print "skip"; ?>
--FILE--
<?php
require 'vendor/autoload.php';

use ZE\ZendObject;

$a = 5208;

printf("Original - %d\n", ($a));
var_dump(ntohs($a));
var_dump(ntohl($a));
var_dump(htons($a));
$ci = c_int_type('int', 'ze', htonl($a));
var_dump($ci);
$cs = c_struct_type('_php_socket', 'ze', [
    'bsd_socket' => 1,
    'type' => 44,
    'error' => 0,
    'blocking' => 1,
    'zstream' => zval_constructor($ci)()[0],
    'std' => ZendObject::init($ci)()[0]
]);
var_dump($cs->sizeof());
var_dump($cs->alignof());
var_dump($cs->char());
var_dump($cs->void());
var_dump($cs->cast('zend_resource*'));
var_dump((string)$cs);
var_dump($cs);
var_dump($cs->string());
var_dump($cs->addr('bsd_socket'));
var_dump($cs->type('zstream'));
var_dump($cs->new());
var_dump($cs->typeof());
var_dump($cs->isNull());
var_dump($cs->free());
var_dump($cs->isNull());
$ct = c_array_type('zend_property_info_list', 'ze', 3);
var_dump($ct);
--EXPECTF--
Original - 5208
int(22548)
int(1477705728)
int(22548)
object(CStruct)#%d (2) {
  ["type"]=>
  string(8) "int32_t*"
  ["value"]=>
  int(1477705728)
}
int(88)
int(8)
object(FFI\CData:char*)#%d (1) {
  [0]=>
%S
}
object(FFI\CData:void*)#%d (1) {
  [0]=>
  int(%d)
}
object(FFI\CData:struct _zend_resource*)#%d (1) {
  [0]=>
  object(FFI\CData:struct _zend_resource)#%d (4) {
    ["gc"]=>
    object(FFI\CData:struct _zend_refcounted_h)#%d (2) {
      ["refcount"]=>
      int(1)
      ["u"]=>
      object(FFI\CData:union <anonymous>)#%d (1) {
        ["type_info"]=>
        int(44)
      }
    }
    ["handle"]=>
    int(0)
    ["type"]=>
    int(1)
    ["ptr"]=>
    object(FFI\CData:void*)#%d (1) {
      [0]=>
      int(%d)
    }
  }
}
string(19) "struct _php_socket*"
object(CStruct)#%d (1) {
  ["type"]=>
  string(19) "struct _php_socket*"
}
string(0) ""
object(FFI\CData:int32_t*)#%d (1) {
  [0]=>
  int(1)
}
object(FFI\CType:struct _zval_struct)#%d (0) {
}
object(CStruct)#%d (1) {
  ["type"]=>
  string(20) "struct _php_socket**"
}
object(FFI\CType:struct _php_socket*)#%d (0) {
}
bool(false)
NULL
bool(true)
object(CStruct)#%d (1) {
  ["type"]=>
  string(21) "struct <anonymous>[3]"
}
