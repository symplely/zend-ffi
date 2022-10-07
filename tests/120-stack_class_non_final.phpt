--TEST--
Check for Stack Class Non Final
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

    public function setNonFinal()
    {
        $this->refClass->final(false);
        var_dump($this->refClass->isFinal() === false);

        $instance = new class extends Dummy
        {
        };
        var_dump($instance instanceof Dummy);
    }

    public function run()
    {
        $this->setNonFinal();
    }
}

$test = new Entry();
$test->run();
--EXPECTF--
bool(true)
