--TEST--
Check for Stack Constant - setDeclaringClass
--SKIPIF--
<?php if (!extension_loaded("ffi")) print "skip"; ?>
--FILE--
<?php
require 'vendor/autoload.php';

use Tests\Dummy;
use ZE\ZendClassConstant;
use ZE\ZendClassEntry;

class Entry
{
    private $refConstant;
    protected $data;

    public function __construct()
    {
        $this->data = new Dummy();
        $this->refConstant = ZendClassConstant::init(Dummy::class, 'SOME_CONST');
    }

    public function getDeclaringClassInstance(): void
    {
        $class = $this->refConstant->declaringClass();
        var_dump($class instanceof ZendClassEntry);
        var_dump(Dummy::class === $class->getName());
    }

    public function setDeclaringClass(): void
    {
        try {
            $this->refConstant->declaringClass(self::class);
            var_dump(self::class === $this->refConstant->getDeclaringClass()->getName());
        } finally {
            $this->refConstant->declaringClass(Dummy::class);
        }
    }

    public function run()
    {
        $this->getDeclaringClassInstance();
        $this->setDeclaringClass();
    }
}

$test = new Entry();
$test->run();
--EXPECTF--
bool(true)
bool(true)
bool(true)
