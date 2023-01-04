--TEST--
Check for object handler cast
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
    public function getCastObject(): void
    {
        $handler = \Closure::fromCallable([DummyNumber::class, '__init']);
        $this->refClass->createObject($handler);
        $this->refClass->castObject(function (CastObject $hook) {
            $castType = $hook->cast_type();
            switch ($castType) {
                case \ZE::IS_LONG:
                case \ZE::_IS_NUMBER:
                    return 1;
                case \ZE::IS_DOUBLE:
                    return 2.0;
                case \ZE::IS_STRING:
                    return 'test';
                case \ZE::_IS_BOOL:
                    return false;
            }
            throw new \UnexpectedValueException("Unknown type " . Zval::name($castType));
        });

        $testClass = new Dummy();
        $long = (int)$testClass;
        var_dump(1 === $long);

        $double = (float)$testClass;
        var_dump(2.0 === $double);

        $string = (string)$testClass;
        var_dump('test' === $string);

        $bool = (bool)$testClass;
        var_dump(false === $bool);
    }

    public function run()
    {
        $this->getCastObject();
    }
}

$Test = new Entry();
$Test->run();
--EXPECTF--
bool(true)
bool(true)
bool(true)
bool(true)
