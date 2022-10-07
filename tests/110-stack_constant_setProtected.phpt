--TEST--
Check for Stack Constant - setProtected
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

    public function setProtected(): void
    {
        $this->refConstant->protected();
        var_dump($this->refConstant->isProtected() === true);
        var_dump($this->refConstant->isPrivate() === false);
        var_dump($this->refConstant->isPublic() === false);

        try {
            var_dump(123 === Dummy::SOME_CONST);
        } catch (\Error $th) {
            echo $th->getMessage(). \EOL;
        }

        // We can override+call protected method from child by making it public
        $child = new class extends Dummy
        {
            public function getConstant()
            {
                // return parent const which is protected now
                return parent::SOME_CONST;
            }
        };

        $value = $child->getConstant();
        var_dump(123 === $value);
    }

    public function run()
    {
        $this->setProtected();
    }
}

$test = new Entry();
$test->run();
--EXPECTF--
bool(true)
bool(true)
bool(true)
Cannot access protected const Tests\Dummy::SOME_CONST
