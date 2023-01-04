--TEST--
Check for object handler get properties for
--SKIPIF--
<?php if (!extension_loaded("ffi")) print "skip"; ?>
--FILE--
<?php
require 'vendor/autoload.php';

use ZE\Hook\CastObject;
use ZE\Hook\CompareValues;
use ZE\Hook\CreateObject;
use ZE\Hook\DoOperation;
use ZE\Hook\GetPropertiesFor;
use ZE\Hook\HasProperty;
use ZE\Hook\InterfaceGetsImplemented;
use ZE\Hook\ReadProperty;
use ZE\Hook\UnsetProperty;
use ZE\Hook\WriteProperty;
use Tests\DummyNumber;
use Tests\Dummy;
use Tests\DummyInterface;
use ZE\Zval;
use ZE\OpCode;
use ZE\ZendClassEntry;

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

    /**
     * @runInSeparateProcess
     */
    public function getGetPropertiesFor(): void
    {
        $handler = \Closure::fromCallable([DummyNumber::class, '__init']);
        $this->refClass->createObject($handler);
        $this->refClass->getPropertiesFor(function (GetPropertiesFor $hook) {
            var_dump(is_object($hook->object()));
            return ['a' => 1, 'b' => true, 'c' => 42.0];
        });

        $instance = new Dummy();
        $instance->property = 10;
        $castValue = (array) $instance;

        // We expect that our handler is called, thus no existing public fields will be returned
        var_dump(!array_key_exists('property', $castValue));

        // Instead we can control how to cast object to array
        var_dump(['a' => 1, 'b' => true, 'c' => 42.0] === $castValue);
    }

    public function run()
    {
        $this->getGetPropertiesFor();
    }
}

$Test = new Entry();
$Test->run();
--EXPECTF--
bool(true)
bool(true)
bool(true)
