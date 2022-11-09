--TEST--
Check/Test zend_fcall_info_call
--SKIPIF--
<?php if (!extension_loaded("ffi")) print "skip"; ?>
--FILE--
<?php
require 'vendor/autoload.php';

var_dump(
    zend_fcall_info_call(function (int $test = null) {
        return 'ok ' . $test;
    }, 1)
);

--EXPECTF--
string(4) "ok 1"
