--TEST--
Check for object handler create & interface gets implemented
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
    public function getCreateObject(): void
    {
        $log = '';
        $this->refClass->createObject(function (CreateObject $hook) use (&$log) {
            $log    .= 'Before initialization.' . PHP_EOL;
            $object = $hook->continue();
            $log    .= 'After initialization.';

            return $object;
        });

        $instance = new Dummy();
        // We should get instance of our original object, because we are calling default handler
        var_dump($instance instanceof Dummy);
        var_dump($log);
    }

    public function getInterfaceGetsImplemented(): void
    {
        $log = '';
        $refInterface = new ZendClassEntry(DummyInterface::class);
        $refInterface->interfaceGetsImplemented(function (InterfaceGetsImplemented $hook) use (&$log) {
            $log = 'Class ' . $hook->get_class()->getName() . ' implements interface';

            return \ZE::SUCCESS;
        });

        // Check that log line is empty now
        var_dump('' === $log);

        // Now we expect that at this point of time our callback will be called
        $anonymousInterfaceImplementation = new class implements DummyInterface
        {
        };

        // Of course, we should get an instance of our DummyInterface
        var_dump($anonymousInterfaceImplementation instanceof DummyInterface);

        // ... and log entry will contain a record about anonymous class that implements interface
        var_dump($log);
    }

    public function run()
    {
        $this->getCreateObject();
        $this->getInterfaceGetsImplemented();
    }
}

$Test = new Entry();
$Test->run();
--EXPECTF--
bool(true)
string(%d) "Before initialization.
After initialization."
bool(true)
bool(true)
string(%d) "Class class@anonymous%S
