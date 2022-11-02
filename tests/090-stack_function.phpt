--TEST--
Check for Stack ZendFunction
--SKIPIF--
<?php if (!extension_loaded("ffi")) print "skip"; ?>
--FILE--
<?php
require 'vendor/autoload.php';

use Tests\Dummy;
use FFI\CData;
use ZE\Zval;
use ZE\ZendMethod;
use ZE\ZendClassEntry;
use ZE\ZendFunction;

function test_function(): ?string
{
    return 'Test';
}

class Entry
{
    protected $refFunction;

    public function __construct()
    {
        $this->refFunction = ZendFunction::init('test_function');
    }

    public function setInternalFunctionDeprecated(): void
    {
        try {
            $currentReporting = error_reporting();
            error_reporting(E_ALL);
            $refFunction = ZendFunction::init('var_dump');
            $refFunction->deprecated();
            var_dump($refFunction->isDeprecated() === true);
            is_int($currentReporting);
        } finally {
            error_reporting($currentReporting);
            $refFunction->deprecated(false);
        }
    }

    public function getRedefineIncompatibleCallback(): void
    {
        try {
            $this->refFunction->redefine(function () {
                echo 'Nope';
            });
        } catch (\ReflectionException $th) {
            echo $th->getMessage() . \EOL;
        }
    }

    public function getRedefine(): void
    {
        $this->refFunction->redefine(function (): ?string {
            return 'Yes';
        });

        // Check that all main info were preserved
        var_dump($this->refFunction->isClosure() === false);
        var_dump('test_function' === $this->refFunction->getShortName());

        $result = test_function();

        // Our function now returns Yes instead of Test
        var_dump('Yes' === $result);
    }

    public function getRedefineInternalFunc(): void
    {
        $originalValue = zend_version();
        $refFunction = ZendFunction::init('zend_version');
        if (\IS_PHP74)
            $refFunction->redefine(function () {
                return 'zend-ffi';
            });
        else
            $refFunction->redefine(function (): string {
                return 'zend-ffi';
            });

        $modifiedValue = zend_version();
        var_dump($originalValue !== $modifiedValue);
        var_dump('zend-ffi' === $modifiedValue);
    }

    public function run()
    {
        $this->setInternalFunctionDeprecated();
        $this->getRedefineIncompatibleCallback();
        $this->getRedefine();
        $this->getRedefineInternalFunc();
    }
}

$test = new Entry();
$test->run();
--EXPECTF--
Deprecated: Function var_dump() is deprecated in %s
bool(true)
Given function signature: "function ()" should be compatible with original "function (): ?string"
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
