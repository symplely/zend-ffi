--TEST--
Check/Test Standard Module
--SKIPIF--
<?php if (!extension_loaded("ffi")) print "skip"; ?>
--FILE--
<?php
require 'vendor/autoload.php';

final class SimpleCountersModule extends \StandardModule
{
    protected string $ffi_tag = 'ze';
    protected string $module_version = '0.4';
    protected ?string $global_type = 'unsigned int[10]';
    protected bool $m_startup = true;

    public function module_startup(int $type, int $module_number): int
    {
        SimpleCountersModule::set_module($this);
        echo 'module_startup' . \PHP_EOL;
        return \ZE::SUCCESS;
    }

    public function global_startup(\FFI\CData $memory): void
    {
        if (\PHP_ZTS) {
            \tsrmls_activate();
        }

        echo 'global_startup' . \PHP_EOL;
        \FFI::memset($this->get_globals(), 0, $this->globals_size());
    }
}

$module = new SimpleCountersModule();
if (!$module->is_registered()) {
    $module->register();
    $module->startup();
}

var_dump(SimpleCountersModule::get_module());
$data = $module->get_globals();
$data[0] = 5;
$data[9] = 15;
var_dump($data);

ob_start();
phpinfo(8);
$value = ob_get_clean();

preg_match('/simple_counters support => enabled/', $value, $matches);
var_dump($matches[0]);
var_dump(SimpleCountersModule::get_name());
var_dump($module->global_type_id());

SimpleCountersModule::set_module(null);
$module->__destruct();
var_dump($module->global_type_id());

--EXPECTF--
global_startup
module_startup
object(SimpleCountersModule)#%d (8) {
  ["_debug"]=>
  bool(false)
  ["_thread_safe"]=>
  bool(true)
  ["_size"]=>
  int(%d)
  ["_globals_size"]=>
  int(%d)
  ["_globals"]=>
  object(FFI\CData:int32_t*)#%d (1) {
    [0]=>
    int(%d)
  }
  ["_module_started"]=>
  bool(true)
  ["_module_number"]=>
  int(0)
  ["_zend_api"]=>
  int(%d)
}
object(FFI\CData:uint32_t[10])#%d (10) {
  [0]=>
  int(5)
  [1]=>
  int(0)
  [2]=>
  int(0)
  [3]=>
  int(0)
  [4]=>
  int(0)
  [5]=>
  int(0)
  [6]=>
  int(0)
  [7]=>
  int(0)
  [8]=>
  int(0)
  [9]=>
  int(15)
}
string(34) "simple_counters support => enabled"
string(15) "simple_counters"
int(%d)
NULL
