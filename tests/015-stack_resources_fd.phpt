--TEST--
Check for Stack resources file descriptor
--SKIPIF--
<?php if (!extension_loaded("ffi")) print "skip"; ?>
--FILE--
<?php
require 'vendor/autoload.php';

$fd = fopen(__FILE__, 'r');
var_dump($fd);
$int_fd = \get_fd_resource($fd);
var_dump($int_fd);
[$zval, $fd1] = \zval_to_fd_pair($fd);
var_dump($zval, $fd1);
var_dump(\get_resource_fd($fd1));
var_dump($int_fd === $fd1);
remove_fd_resource($fd);
remove_fd_resource($fd1);
fclose($fd);
$fd = fopen(__FILE__, 'r');
$socket_fd = \get_socket_fd($fd);
var_dump($socket_fd);
remove_fd_resource($fd);
fclose($fd);
--EXPECTF--
resource(%d) of type (stream)
int(%d)
object(ZE\Zval)#%d (2) {
  ["type"]=>
  string(11) "IS_RESOURCE"
  ["value"]=>
  resource(%d) of type (stream)
}
int(%d)
resource(%d) of type (stream)
bool(true)

Warning: invalid resource passed, this plain files are not supported in %S
int(-1)
