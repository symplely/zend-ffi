--TEST--
Check for Stack Class Abstract
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

    public function run()
    {
        $this->setAbstract();
        $this->setNonAbstract();
    }
}

$test = new Entry();
$test->run();
--EXPECTF--
bool(true)
Cannot instantiate abstract class Tests\Dummy
bool(true)
bool(true)
