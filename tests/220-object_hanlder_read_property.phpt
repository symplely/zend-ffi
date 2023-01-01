--TEST--
Check for object handler read property
--SKIPIF--
<?php if (!extension_loaded("ffi")) print "skip"; ?>
--FILE--
<?php
require 'vendor/autoload.php';

use Closure;
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
    public function getReadProperty(): void
    {
        $handler = Closure::fromCallable([DummyNumber::class, '__init']);
        $this->refClass->createObject($handler);
        $this->refClass->readProperty(function (ReadProperty $hook) {
            $value = $hook->continue();
            return $value * 2;
        });
        $instance = new Dummy();
        $value = $instance->property;
        var_dump(42 != $value);
        var_dump(42 * 2 === $value);

        $secret = $instance->tellSecret();
        var_dump(100500 * 2 === $secret);
    }

    public function run()
    {
        $this->getReadProperty();
    }
}

$Test = new Entry();
$Test->run();
--EXPECTF--
bool(true)
bool(true)
bool(true)
