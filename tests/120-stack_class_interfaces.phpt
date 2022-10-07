--TEST--
Check for Stack Class Interfaces
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
    protected $data;

    /** @var ZendClassEntry|\ReflectionClass */
    private $refClass;

    public function __construct()
    {
        $this->data = new Dummy();
        $this->refClass = new class(Dummy::class) extends ZendClassEntry
        {
        };
    }

    public function getAddInterfaces(): void
    {
        $object = new Dummy();

        $this->refClass->addInterfaces(DummyInterface::class);
        var_dump($object instanceof DummyInterface);

        // As we adjusted list of interfaces, typehint should pass
        $checkTypehint = function (DummyInterface $e): DummyInterface {
            return $e;
        };

        $value = $checkTypehint($object);
        var_dump($object === $value);

        // Also, interface should be in the list of interface names for this class
        var_dump(in_array(DummyInterface::class, $this->refClass->getInterfaceNames(), true) === true);
    }

    public function getRemoveInterfaces(): void
    {
        $this->refClass->removeInterfaces(DummyInterface::class);
        var_dump(!$this instanceof DummyInterface);

        // Also, interface should not be in the list of interface names for this class
        var_dump(in_array(DummyInterface::class, $this->refClass->getInterfaceNames(), true) === false);
    }

    public function getAddRemoveInterfacesInternal(): void
    {
        $refClosureClass = ZendClassEntry::init(\Closure::class);
        $refClosureClass->addInterfaces(DummyInterface::class);

        $checkTypeHint = function (DummyInterface $e): DummyInterface {
            return $e;
        };
        // Closure should implements DummyInterface right now, so it should pass itself
        $result = $checkTypeHint($checkTypeHint);
        var_dump($result instanceof DummyInterface);

        $refClosureClass->removeInterfaces(DummyInterface::class);
        var_dump(!$result instanceof DummyInterface);
    }

    public function getClassConstantsExtendedClass()
    {
        $refConstant = $this->refClass->getReflectionConstant('SOME_CONST');
        var_dump($refConstant instanceof ZendClassConstant);
    }

    public function run()
    {
        $this->getAddInterfaces();
        $this->getRemoveInterfaces();
        $this->getAddRemoveInterfacesInternal();
        $this->getClassConstantsExtendedClass();
    }
}

$test = new Entry();
$test->run();
--EXPECTF--
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
