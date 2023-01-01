--TEST--
Check for object handler install handlers
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

    public function getInstallHandlers(): void
    {
        $refClass = new ZendClassEntry(DummyNumber::class);
        $refClass->install_handlers();

        /** @var int */
        $a = new DummyNumber(46);

        /** @var int */
        $b = new DummyNumber(2);

        $c = $a + $b;
        var_dump(48 === (int) $c);

        $d = $a / $b;
        var_dump(23.0 === (float) $d);

        $e = $a > 10 && $a < 50;
        // 'Number should be equal to 46'
        var_dump($e == -true);

        $f = ($a * 2) < 100;
        // '46*2=92 is less than 100'
        var_dump($f === true);
    }

    public function run()
    {
        $this->getInstallHandlers();
    }
}

$Test = new Entry();
$Test->run();
--EXPECTF--
bool(true)
bool(true)
bool(true)
bool(true)
