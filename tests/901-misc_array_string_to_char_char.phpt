--TEST--
Check for ffi_char_variadic
--SKIPIF--
<?php if (!extension_loaded("ffi") || (('/' === DIRECTORY_SEPARATOR) && (PHP_OS !== 'Darwin') && ((float) \phpversion() < 8.0))) print "skip"; ?>
--FILE--
<?php
require 'vendor/autoload.php';

$commands = ffi_char_variadic('php', 'test.php', '2');
var_dump($commands);
var_dump(ffi_string($commands[0]));
var_dump(ffi_string($commands[1]));
var_dump(ffi_string($commands[2]));
--EXPECTF--
object(FFI\CData:char**)#%d (1) {
  [0]=>
  object(FFI\CData:char*)#%d (1) {
    [0]=>
    string(1) "p"
  }
}
string(3) "php"
string(8) "test.php"
string(1) "2"
