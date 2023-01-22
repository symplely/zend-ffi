--TEST--
Check/Test zend_execute_scripts
--SKIPIF--
<?php if (!extension_loaded("ffi") || (('/' === DIRECTORY_SEPARATOR) && (PHP_OS !== 'Darwin') && ((float) \phpversion() < 8.0))) print "skip"; ?>
--FILE--
<?php
require 'vendor/autoload.php';

var_dump(zend_execute_scripts(__DIR__ . \DS . 'DummyRequest.php'));

--EXPECTF--
string(%d) "ok 1 - hello"
