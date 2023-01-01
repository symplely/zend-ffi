--TEST--
Check for object handler has property
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
    public function getHasProperty(): void
    {
        $logEntry = '';
        $handler  = Closure::fromCallable([DummyNumber::class, '__init']);
        $this->refClass->createObject($handler);
        $this->refClass->hasProperty(function (HasProperty $hook) use (&$logEntry) {
            $logEntry = $hook->member_name();
            // Let's inverse presence of field :)
            return (int)(!$hook->continue());
        });

        $instance = new Dummy();
        var_dump(isset($instance->property) === false);
        var_dump('property', $logEntry);
        var_dump(isset($instance->unknown) === true);
        var_dump('unknown' === $logEntry);
    }

    public function run()
    {
        $this->getHasProperty();
    }
}

$Test = new Entry();
$Test->run();
--EXPECTF--
bool(true)
bool(true)
bool(true)
bool(true)
