--TEST--
Check for Stack Constant
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

    public function setProtected(): void
    {
        $this->refConstant->protected();
        var_dump($this->refConstant->isProtected() === true);
        var_dump($this->refConstant->isPrivate() === false);
        var_dump($this->refConstant->isPublic() === false);

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

        try {
            var_dump(123 === Dummy::SOME_CONST);
        } catch (\Error $th) {
            echo $th->getMessage(). \EOL;
        }
    }

    public function setPublic(): void
    {
        $this->refConstant->public();
        var_dump($this->refConstant->isPublic() === true);
        var_dump($this->refConstant->isPrivate() === false);
        var_dump($this->refConstant->isProtected() === false);

        var_dump(123 === Dummy::SOME_CONST);
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
        $this->setPrivate();
        $this->setProtected();
        $this->setPublic();
        $this->getDeclaringClassInstance();
        $this->setDeclaringClass();
    }
}

$test = new Entry();
$test->run();
--EXPECT--
bool(true)
bool(true)
bool(true)
Cannot access private const Tests\Dummy::SOME_CONST
bool(true)
bool(true)
bool(true)
bool(true)
Cannot access protected const Tests\Dummy::SOME_CONST
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
