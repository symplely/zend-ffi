--TEST--
Check for ffi_char_assoc
--SKIPIF--
<?php if (!extension_loaded("ffi") || (('/' === DIRECTORY_SEPARATOR) && (PHP_OS !== 'Darwin') && ((float) \phpversion() < 8.0))) print "skip"; ?>
--FILE--
<?php
require 'vendor/autoload.php';

$env = ffi_char_assoc(["KEY" => "hello"], ["KEY1" => "hello1"]);
var_dump($env);
var_dump(ffi_string($env[0]));
var_dump(ffi_string($env[1]));

--EXPECTF--
object(FFI\CData:char**)#%d (1) {
  [0]=>
  object(FFI\CData:char*)#%d (1) {
    [0]=>
    string(1) "K"
  }
}
string(9) "KEY=hello"
string(11) "KEY1=hello1"
