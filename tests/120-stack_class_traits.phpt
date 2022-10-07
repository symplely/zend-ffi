--TEST--
Check for Stack Class Traits
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

    public function run()
    {
        $this->getAddTraits();
        $this->getRemoveTraits();
    }
}

$test = new Entry();
$test->run();
--EXPECTF--
bool(true)
bool(true)
