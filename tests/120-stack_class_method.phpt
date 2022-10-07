--TEST--
Check for Stack Class Add Remove Method
--SKIPIF--
<?php if (!extension_loaded("ffi")) print "skip"; ?>
--FILE--
<?php
require 'vendor/autoload.php';

use Tests\Dummy;
use Tests\DummyTrait;
use Tests\DummyInterface;
use ZE\ZendClassEntry;
use ZE\ZendClassConstant;

class Entry
{
    /** @var ZendClassEntry|\ReflectionClass */
    private $refClass;

    public function __construct()
    {
        $data = new Dummy();
        $this->refClass = new class(Dummy::class) extends ZendClassEntry
        {
        };
    }

    public function getRemoveMethods()
    {
        $this->refClass->removeMethods('methodToRemove');
        $isMethodExists = method_exists(Dummy::class, 'methodToRemove');
        var_dump($isMethodExists === false);
    }

    public function getAddMethod()
    {
        $methodName = 'newMethod';
        $this->refClass->addMethod($methodName, function (string $argument): string {
            return $argument;
        });

        $isMethodExists = method_exists(Dummy::class, $methodName);
        var_dump($isMethodExists === true);
        $instance = new Dummy();
        $result = $instance->$methodName('Test');
        var_dump('Test' === $result);
    }

    public function run()
    {
        $this->getRemoveMethods();
        $this->getAddMethod();
    }
}

$test = new Entry();
$test->run();
--EXPECTF--
bool(true)
bool(true)
bool(true)
