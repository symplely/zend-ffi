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
$ci = c_int_type('int32_t', htonl($a));
var_dump($ci);
$cs = c_struct_type('_php_socket', [
    'bsd_socket' => 1,
    'type' => 44,
    'error' => 0,
    'blocking' => 1,
    'zstream' => zval_constructor($ci)()[0],
    'std' => ZendObject::init($ci)()[0]
]);
var_dump($cs);
--EXPECTF--
Original - 5208
int(22548)
int(1477705728)
int(22548)
object(CInteger)#%d (%d) {
  ["type"]=>
  string(%d) "int32_t*"
  ["value"]=>
  int(1477705728)
}
object(CStruct)#10 (1) {
  ["type"]=>
  string(19) "struct _php_socket*"
}
