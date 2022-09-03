--TEST--
Check for Stack Module
--SKIPIF--
<?php if (!extension_loaded("ffi")) print "skip"; ?>
--FILE--
require 'vendor/autoload.php';

use ZE\ZendModule;

class Entry
{
    private $refExtension;

    public function __construct()
    {
        // As FFI is always required for this framework, we can be sure that it is present
        $this->refExtension = ZendModule::init('ffi');
    }

    public function getThreadSafe(): void
    {
        var_dump(ZEND_THREAD_SAFE === $this->refExtension->is_thread_safe());
    }

    public function getIsDebug(): void
    {
        var_dump(ZEND_DEBUG_BUILD === $this->refExtension->is_debug());
    }

    public function getModuleWasStarted(): void
    {
        // Built-in modules always started, only our custom modules may be in non-started state
        var_dump($this->refExtension->module_started() == true);
    }

    public function getModuleNumber(): void
    {
        // each module has it's own unique module number greater than zero
        var_dump($this->refExtension->module_number() > 0);
    }

    public function getGlobals(): void
    {
        /* @see https://github.com/php/php-src/blob/PHP-7.4/ext/ffi/php_ffi.h#L33-L63 */
        var_dump($this->refExtension->globals() !== null);
    }

    public function getGlobalsSize(): void
    {
        /* @see https://github.com/php/php-src/blob/PHP-7.4/ext/ffi/php_ffi.h#L33-L63 */
        var_dump($this->refExtension->globals_size() > 0);
    }

    public function run()
    {
        $this->getThreadSafe();
        $this->getIsDebug();
        $this->getModuleWasStarted();
        $this->getModuleNumber();
        $this->getGlobals();
        $this->getGlobalsSize();
    }
}

$test = new Entry();
$test->run();
--EXPECT--
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
