--TEST--
Check for Stack Class Line Filename
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

    public function getStartLine(): void
    {
        var_dump(7 === $this->refClass->getStartLine());
        $this->refClass->line_start(1);
        var_dump(1 === $this->refClass->getStartLine());
    }

    public function setEndLine(): void
    {
        $totalLines = \count(\file($this->refClass->getFileName()));
        var_dump($totalLines === $this->refClass->getEndLine());
        $this->refClass->line_end(1);
        var_dump(1 === $this->refClass->getEndLine());
    }

    public function getSetFileName()
    {
        // Take the file name to restore later
        $originalFileName = $this->refClass->getFileName();
        $this->refClass->filename('/etc/passwd');
        var_dump('/etc/passwd' === $this->refClass->getFileName());
        $this->refClass->filename($originalFileName);
        var_dump($originalFileName === $this->refClass->getFileName());
    }

    public function run()
    {
        $this->getStartLine();
        $this->setEndLine();
        $this->getSetFileName();
    }
}

$test = new Entry();
$test->run();
--EXPECTF--
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
