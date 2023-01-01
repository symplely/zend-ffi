--TEST--
Check for object handler compare values
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
    public function getCompareValues(): void
    {
        $handler = \Closure::fromCallable([DummyNumber::class, '__init']);
        $this->refClass->createObject($handler);
        $this->refClass->compareValues(function (CompareValues $hook) {
            $left  = $hook->op1();
            $right = $hook->op2();
            if (is_object($left)) {
                $left = spl_object_id($left);
            }
            if (is_object($right)) {
                $right = spl_object_id($right);
            }

            return $left <=> $right;
        });

        $first = new Dummy();
        $second = new Dummy();

        $firstId = spl_object_id($first);
        $secondId = spl_object_id($second);

        // As we compare values by object_id, then we should expect same values as simple int comparison
        var_dump(($firstId < $secondId) === ($first < $second));
        var_dump(($firstId == $secondId) === ($first == $second));
        var_dump(($firstId >= $secondId) === ($first >= $second));

        // We can also compare objects with values directly, look at $secondId arg
        var_dump($firstId < $secondId === $first < $secondId);
        var_dump($firstId > $secondId === $firstId > $second);
    }

    public function run()
    {
        $this->getCompareValues();
    }
}

$Test = new Entry();
$Test->run();
--EXPECTF--
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
