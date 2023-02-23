--TEST--
Check for Stack Resource
--SKIPIF--
<?php if (!extension_loaded("ffi")) print "skip"; ?>
--FILE--
<?php
require 'vendor/autoload.php';

$file = fopen(__FILE__, 'r');

function get_stack_resource($file, $extra = null): void
{
    $zval = zval_stack(0);
    var_dump($zval);

    $zval = zval_stack(1);
    var_dump($zval);

    $refResource = \zend_resource($file);

    preg_match('/Resource id #(\d+)/', (string)$file, $matches);
    var_dump((int)$matches[1] === $refResource->handle());

    $refResource->handle(1);
    var_dump(1 === $refResource->handle());

    $rawData = $refResource->ptr();
    var_dump(\is_cdata($rawData));

    // stream resource type has an id=2
    var_dump(2 === $refResource->type());

    // persistent_stream has type=3
    $refResource->type(3);
    var_dump(3 === $refResource->type());

    ob_start();
    var_dump($file);
    $value = ob_get_clean();

    preg_match('/resource\(\d+\) of type \(([^)]+)\)/', $value, $matches);
    var_dump('persistent stream' === $matches[1]);
    if (\IS_PHP83) {
        var_dump(ffi_str_typeof($zval()));
        var_dump(print_r(\FFI::typeof($zval()), true));
    }

    var_dump(is_typeof(ffi_object($zval), 'struct _zval_struct*'));
}

get_stack_resource($file, 'test');

fclose($file);
--EXPECTF--
object(ZE\Zval)#%d (2) {
  ["type"]=>
  string(%d) "IS_RESOURCE"
  ["value"]=>
  resource(%d) of type (stream)
}
object(ZE\Zval)#%d (2) {
  ["type"]=>
  string(%d) "IS_INTERNED_STRING_EX"
  ["value"]=>
  string(%d) "test"
}
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
