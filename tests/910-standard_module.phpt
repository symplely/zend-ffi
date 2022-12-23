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
    protected bool $m_shutdown = true;
    protected bool $r_startup = true;
    protected bool $r_shutdown = true;

    public function module_startup(int $type, int $module_number): int
    {
        SimpleCountersModule::set_module($this);
        echo 'module_startup' . \PHP_EOL;
        return \ZE::SUCCESS;
    }

    public function module_shutdown(int $type, int $module_number): int
    {
        echo 'module_shutdown' . \PHP_EOL;
        return \ZE::SUCCESS;
    }

    public function request_startup(...$args): int
    {
        echo 'request_startup' . \PHP_EOL;
        $data = $this->get_globals();
        $data[5] = 25;
        return \ZE::SUCCESS;
    }

    public function request_shutdown(...$args): int
    {
        echo 'request_shutdown' . \PHP_EOL;
        return \ZE::SUCCESS;
    }

    public function global_startup(\FFI\CData $memory): void
    {
        echo 'global_startup' . \PHP_EOL;
        \FFI::memset($this->get_globals(), 0, $this->globals_size());
    }

    public function global_shutdown(\FFI\CData $memory): void
    {
        parent::global_shutdown($memory);
        echo 'global_shutdown' . \PHP_EOL;
    }
}

$module = new SimpleCountersModule();
if (!$module->is_registered()) {
    $module->register();
    $module->startup();
}

$module->destruct_set();
var_dump(SimpleCountersModule::get_module() instanceof \StandardModule);
$data = $module->get_globals();
$module->get_globals('4', 20);
$data[0] = 5;
$data[9] = 15;
var_dump($data);

ob_start();
phpinfo(8);
$value = ob_get_clean();

preg_match('/simple_counters support => enabled/', $value, $matches);
var_dump($matches[0]);
var_dump(\extension_loaded('simple_counters'));
var_dump(SimpleCountersModule::get_name());
var_dump($module->ffi());
--EXPECTF--
global_startup
module_startup
request_startup
bool(true)
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
  int(20)
  [5]=>
  int(25)
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
bool(true)
string(15) "simple_counters"
object(FFI)#%d (0) {
}
request_shutdown
module_shutdown
global_shutdown
