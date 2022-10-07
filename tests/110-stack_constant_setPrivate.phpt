--TEST--
Check for Stack Constant - setPrivate
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

    public function __construct()
    {
        $data = new Dummy();
        $this->refConstant = ZendClassConstant::init(Dummy::class, 'SOME_CONST');
    }

    public function setPrivate(): void
    {
        $this->refConstant->private();
        var_dump($this->refConstant->isPrivate() === true);
        var_dump($this->refConstant->isPublic() === false);
        var_dump($this->refConstant->isProtected() === false);

        try {
            var_dump(123 === Dummy::SOME_CONST);
        } catch (\Error $th) {
            echo $th->getMessage(). \EOL;
        }
    }

    public function run()
    {
        $this->setPrivate();
    }
}

$test = new Entry();
$test->run();
--EXPECTF--
bool(true)
bool(true)
bool(true)
Cannot access private const Tests\Dummy::SOME_CONST
