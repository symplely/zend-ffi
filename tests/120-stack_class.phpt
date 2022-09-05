--TEST--
Check for Stack Class
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

    public function setAbstract()
    {
        $this->refClass->abstract(true);
        var_dump($this->refClass->isAbstract() === true);

        try {
            new Dummy();
        } catch (\Error $th) {
            echo $th->getMessage() . \EOL;
        }
    }

    public function setNonAbstract()
    {
        $this->refClass->abstract(false);
        var_dump($this->refClass->isAbstract() === false);
        $instance = new Dummy();
        var_dump($instance instanceof Dummy);
    }

    public function setFinal()
    {
        $this->refClass->final(true);
        var_dump($this->refClass->isFinal() === true);
        // Unfortunately, next line wil produce a fatal error, thus can not be tested
        // $test = new class extends Dummy {};
    }

    public function setNonFinal()
    {
        $this->refClass->final(false);
        var_dump($this->refClass->isFinal() === false);

        $instance = new class extends Dummy
        {
        };
        var_dump($instance instanceof Dummy);
    }

    public function getClassConstantsExtendedClass()
    {
        $refConstant = $this->refClass->getReflectionConstant('SOME_CONST');
        var_dump($refConstant instanceof ZendClassConstant);
    }

    public function getAddTraits()
    {
        $this->refClass->addTraits(DummyTrait::class);

        // Trait should be in the list of trait names for this class
        var_dump(in_array(DummyTrait::class, $this->refClass->getTraitNames(), true) === true);
        // TODO: Check that methods were also added to the Dummy class
    }

    public function getRemoveTraits()
    {
        $this->refClass->removeTraits(DummyTrait::class);

        // Trait should not be in the list of trait names for this class
        var_dump(in_array(DummyTrait::class, $this->refClass->getTraitNames(), true) === false);
        // TODO: Check that methods were also removed to the Dummy class
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

    public function getStartLine(): void
    {
        var_dump(7 === $this->refClass->getStartLine());
        $this->refClass->line_start(1);
        var_dump(1 === $this->refClass->getStartLine());
    }

    public function setEndLine(): void
    {
        $totalLines = \count(\file($this->refClass->getFileName()));
        var_dump($totalLines === $this->refClass->getEndLine());
        $this->refClass->line_end(1);
        var_dump(1 === $this->refClass->getEndLine());
    }

    public function getSetFileName()
    {
        // Take the file name to restore later
        $originalFileName = $this->refClass->getFileName();
        $this->refClass->filename('/etc/passwd');
        var_dump('/etc/passwd' === $this->refClass->getFileName());
        $this->refClass->filename($originalFileName);
        var_dump($originalFileName === $this->refClass->getFileName());
    }

    public function run()
    {
        $this->getRemoveMethods();
        $this->getAddMethod();
        $this->setAbstract();
        $this->setNonAbstract();
        $this->setFinal();
        $this->setNonFinal();
        $this->getClassConstantsExtendedClass();
        $this->getAddTraits();
        $this->getRemoveTraits();
        $this->getAddInterfaces();
        $this->getRemoveInterfaces();
        $this->getAddRemoveInterfacesInternal();
        $this->getStartLine();
        $this->setEndLine();
        $this->getSetFileName();
    }
}

$test = new Entry();
$test->run();
--EXPECT--
bool(true)
bool(true)
bool(true)
bool(true)
Cannot instantiate abstract class Tests\Dummy
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
