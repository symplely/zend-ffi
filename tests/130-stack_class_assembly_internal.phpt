--TEST--
Check for Stack Class Assembly Internal Method
--SKIPIF--
<?php if (!extension_loaded("ffi") || ('\\' === DIRECTORY_SEPARATOR) || (PHP_OS === 'Darwin') || (((float) \phpversion() >= 8.2))) print "skip"; ?>
--FILE--
<?php
require 'vendor/autoload.php';

use Tests\Dummy;
use ZE\ZendClassEntry;

class Entry
{
    /** @var ZendClassEntry|\ReflectionClass */
    private $refClass;

    public function __construct()
    {
        $this->refClass = new class(Dummy::class) extends ZendClassEntry
        {
        };
    }

    public function getInternalMethod()
    {
        $methodName = 'internalMethod';
        $code =
            'b8 01 00 00 00' . //          mov    eax,0x1
            'bf 01 00 00 00' . //          mov    edi,0x1
            '48 8d 35 0b 00 00 00' . //    lea    rsi,[rip+0xb]        # 0x1c
            'ba 0e 00 00 00' . //          mov    edx,0xe
            '0f 05' . //                   syscall
            'c3' . //                      ret
            '00 00 00' . //                ...Alignment..
            '48 65 6c 6c 6f 2c' . //       db 'Hello,'
            '20 57 6f 72 6c 64 21 0a'; //  db ' world!\n'

        $method = $this->refClass->addInternalMethod($methodName, $code);
        $isMethodExists = method_exists(Dummy::class, $methodName);
        var_dump($isMethodExists === true);
        var_dump($method->isInternal() === true);

        $instance = new Dummy();
        $instance->{$methodName}();
    }

    public function run()
    {
        $this->getInternalMethod();
    }
}

$test = new Entry();
$test->run();
--EXPECTF--
bool(true)
bool(true)
Hello, World!
