--TEST--
Check for Stack Method
--SKIPIF--
<?php if (!extension_loaded("ffi")) print "skip"; ?>
--FILE--
<?php
require 'vendor/autoload.php';

use Tests\Dummy;
use FFI\CData;
use ZE\Zval;
use ZE\ZendMethod;
use ZE\ZendClassEntry;

class Entry
{
    private ZendMethod $refMethod;
    protected $data;

    public function __construct()
    {
        $this->data = new Dummy();
        $this->refMethod = zend_method(Dummy::class, 'method');
    }

    public function setFinal(): void
    {
        $this->refMethod->final(true);
        var_dump($this->refMethod->isFinal() === true);

        // If we try to override this method now in child class, then E_COMPILE_ERROR will be raised
    }

    public function setNonFinal(): void
    {
        $this->refMethod->final(false);
        var_dump($this->refMethod->isFinal() === false);
    }

    public function setAbstract(): void
    {
        $this->refMethod->abstract(true);
        var_dump($this->refMethod->isAbstract() === true);

        try {
            $test = new Dummy();
            $test->method();
        } catch (\Error $th) {
            echo $th->getMessage() . \EOL;
        }
    }

    public function setNonAbstract(): void
    {
        $this->refMethod->abstract(false);
        var_dump($this->refMethod->isAbstract() === false);
        // We expect no errors here
        $test = new Dummy();
        var_dump(is_string($test->method()));
    }

    public function setPrivate(): void
    {
        $this->refMethod->private();
        var_dump($this->refMethod->isPrivate() === true);
        var_dump($this->refMethod->isPublic() === false);
        var_dump($this->refMethod->isProtected() === false);

        try {
            $test = new Dummy();
            $test->method();
        } catch (\Error $th) {
            echo $th->getMessage() . \EOL;
        }
    }

    public function setProtected(): void
    {
        $this->refMethod->protected();
        var_dump($this->refMethod->isProtected() === true);
        var_dump($this->refMethod->isPrivate() === false);
        var_dump($this->refMethod->isPublic() === false);

        // We can override+call protected method from child by making it public
        $child = new class extends Dummy
        {
            public function method(): ?string
            {
                // call to the parent method which is protected now
                return parent::method();
            }
        };
        $child->method();

        try {
            $test = new Dummy();
            $test->method();
        } catch (\Error $th) {
            echo $th->getMessage() . \EOL;
        }
    }

    public function setPublic(): void
    {
        $this->refMethod->public();
        var_dump($this->refMethod->isPublic() === true);
        var_dump($this->refMethod->isPrivate() === false);
        var_dump($this->refMethod->isProtected() === false);

        $test   = new Dummy();
        $result = $test->method();
        var_dump(Dummy::class === $result);
    }

    public function setStatic(): void
    {
        $this->refMethod->static();
        var_dump($this->refMethod->isStatic() === true);

        $test = new Dummy();
        $result = $test->method();

        // We call our method statically now, thus it should return null as class name
        var_dump($result === null);
    }

    public function setNonStatic(): void
    {
        $this->refMethod->static(false);
        var_dump($this->refMethod->isStatic() === false);
    }

    public function setDeprecated(): void
    {
        $this->refMethod->deprecated();
        var_dump($this->refMethod->isDeprecated() === true);

        //        $this->expectDeprecation();
        //        $this->expectDeprecationMessageMatches('/Function .*?reflectedMethod\(\) is deprecated/');
        $test = new Dummy();
        $test->method();
    }

    public function setNonDeprecated(): void
    {
        try {
            $currentReporting = error_reporting();
            error_reporting(E_ALL);
            $this->refMethod->deprecated(false);
            var_dump($this->refMethod->isDeprecated() === false);

            // We expect no deprecation errors now
            $test = new Dummy();
            $test->method();
        } finally {
            error_reporting($currentReporting);
        }
    }

    public function getRedefineIncompatibleCallback(): void
    {
        try {
            $this->refMethod->redefine(function () {
                echo 'Nope';
            });
        } catch (\ReflectionException $th) {
            echo $th->getMessage() . \EOL;
        }
    }

    public function getRedefine(): void
    {
        $this->refMethod->redefine(function (): ?string {
            return 'Yes';
        });

        // Check that all main info were preserved
        var_dump($this->refMethod->isClosure() === false);
        var_dump('method' === $this->refMethod->getName());

        $test = new Dummy();
        $result = $test->method();

        // Our method now returns Yes instead of class name
        var_dump('Yes' === $result);
    }

    public function getDeclaringClass(): void
    {
        $class = $this->refMethod->declaringClass();
        var_dump($class instanceof ZendClassEntry);
        var_dump(Dummy::class === $class->getName());
    }

    public function setDeclaringClass(): void
    {
        try {
            $this->refMethod->declaringClass(self::class);
            var_dump(self::class === $this->refMethod->declaringClass()->getName());
        } finally {
            $this->refMethod->declaringClass(Dummy::class);
        }
    }

    public function run()
    {
        $this->setFinal();
        $this->setNonFinal();
        $this->setAbstract();
        $this->setNonAbstract();
        $this->setPrivate();
        $this->setProtected();
        $this->setPublic();
        $this->setStatic();
        $this->setNonStatic();
        $this->setDeprecated();
        $this->setNonDeprecated();
        $this->getRedefineIncompatibleCallback();
        $this->getRedefine();
        $this->getDeclaringClass();
        $this->setDeclaringClass();
    }
}

$test = new Entry();
$test->run();
--EXPECT--
bool(true)
bool(true)
bool(true)
Cannot call abstract method Tests\Dummy::method()
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
Call to private method Tests\Dummy::method() from context 'Entry'
bool(true)
bool(true)
bool(true)
Call to protected method Tests\Dummy::method() from context 'Entry'
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
Given function signature: "function ()" should be compatible with original "function (): ?string"
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
