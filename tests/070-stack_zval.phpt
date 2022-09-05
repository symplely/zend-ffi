--TEST--
Check for Stack Zval
--SKIPIF--
<?php if (!extension_loaded("ffi")) print "skip"; ?>
--FILE--
<?php
require 'vendor/autoload.php';

use FFI\CData;
use ZE\Zval;
use ZE\ZendString;

class Entry
{
    public function getConstructor($value, int $expectedType)
    {
        $refValue = zval_constructor($value);
        $type = $refValue->type() & 0xFF;
        var_dump($expectedType === $type);

        $expectedTypeName = Zval::name($expectedType);
        $argTypeName = Zval::name($type);
        var_dump($expectedTypeName === $argTypeName);
    }

    public function getNative($value): void
    {
        // This prevents optimization of opcodes and $value variable GC
        static $currentValue;
        $currentValue = $value;
        $argument = zval_stack(0);
        $argument->native_value($returnedValue);
        var_dump($currentValue === $returnedValue);
    }

    public function valueProvider(): array
    {
        return [
            [1],
            [1.0],
            ['Test'],
            [new \stdClass()],
            [[1, 2, 3]]
        ];
    }

    public function typeProvider(): array
    {
        $valueByRef = new \stdClass();
        return [
            [1, \ZE::IS_LONG],
            [1.0, \ZE::IS_DOUBLE],
            ['Test', \ZE::IS_STRING],
            [new \stdClass(), \ZE::IS_OBJECT],
            [[1, 2, 3], \ZE::IS_ARRAY],
            [null, \ZE::IS_NULL],
            [false, \ZE::IS_FALSE],
            [true, \ZE::IS_TRUE],
            [fopen(__FILE__, 'r'), \ZE::IS_RESOURCE]
        ];
    }

    public function getTypeProvider()
    {
        foreach ($this->typeProvider() as $expect) {
            [$value, $type] = $expect;
            $this->getConstructor($value, $type);
        }
    }

    public function getValueProvider()
    {
        foreach ($this->valueProvider() as $value) {
            $this->getNative($value);
        }
    }

    public function getClass()
    {
        $classEntry = zend_executor()->class_table()->find(strtolower(self::class));
        var_dump($classEntry instanceof Zval);
        $rawClass = $classEntry->ce();
        var_dump($rawClass instanceof CData);

        // Let's check the name from this structure
        $className = ZendString::init_value($rawClass->name);
        var_dump(self::class === $className->value());
    }

    public function getFunction()
    {
        $functionEntry = zend_executor()->function_table()->find('var_dump');
        var_dump($functionEntry instanceof Zval);
        $rawFunction = $functionEntry->func();
        var_dump($rawFunction instanceof CData);

        // Let's check the name from this structure
        $functionName = ZendString::init_value($rawFunction->function_name);
        var_dump('var_dump' === $functionName->value());
    }

    public function getValue()
    {
        $classEntry = zend_executor()->class_table()->find(strtolower(self::class));
        $rawValue   = $classEntry();

        $valueEntry = zend_value($rawValue);
        var_dump(\ZE::IS_PTR === $valueEntry->type());
    }

    public function getObject()
    {
        $thisValue = zend_executor()->This();
        $rawObject = $thisValue->obj();
        var_dump(\is_cdata($rawObject) === true);

        $object = zend_object($rawObject);
        // Check that we have the same object by checking handle
        var_dump(spl_object_id($this) === $object->handle());
    }

    public function getString()
    {
        $value = self::class;
        get_defined_vars(); // This triggers Symbol Table rebuilt under the hood

        $valueEntry = zend_executor()->symbol_table()->find('value');

        // We know that $valueEntry is indirect pointer to string
        var_dump(\ZE::IS_INDIRECT === $valueEntry->type());

        $rawString = $valueEntry->zv()->str();
        $stringEntry = zend_string($rawString);
        var_dump(self::class === $stringEntry->value());
    }

    public function run()
    {
        $this->getTypeProvider();
        $this->getValueProvider();
        $this->getClass();
        $this->getFunction();
        $this->getValue(false);
        $this->getObject();
        $this->getString();
    }
}

$test = new Entry();
$test->run();
--EXPECT--
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
