--TEST--
Check for Stack Class Final
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

    public function setFinal()
    {
        $this->refClass->final(true);
        var_dump($this->refClass->isFinal() === true);
        // Unfortunately, next line wil produce a fatal error, thus can not be tested
         $test = new class extends Dummy {};
    }

    public function run()
    {
        $this->setFinal();
    }
}

$test = new Entry();
$test->run();
--EXPECTF--
bool(true)

Fatal error: Class %S
