--TEST--
Check/Test zend_fcall_info_call
--SKIPIF--
<?php if (!extension_loaded("ffi") || (('/' === DIRECTORY_SEPARATOR) && (PHP_OS !== 'Darwin') && ((float) \phpversion() < 8.0))) print "skip"; ?>
--FILE--
<?php
require 'vendor/autoload.php';

var_dump(
    zend_fcall_info_call(function (int $test, string $test2) {
        return 'ok ' . $test . ' - ' . $test2;
    }, 1, 'test')
);

--EXPECTF--
string(11) "ok 1 - test"
