<?php

declare(strict_types=1);

namespace Tests;

require 'vendor/autoload.php';

use Closure;
use ZE\Hook\CastObject;
use ZE\Hook\CompareValues;
use ZE\Hook\CreateObject;
use ZE\Hook\DoOperation;
use ZE\Hook\GetPropertiesFor;
use ZE\Hook\HasProperty;
use ZE\Hook\InterfaceGetsImplemented;
use ZE\Hook\ReadProperty;
use ZE\Hook\UnsetProperty;
use ZE\Hook\WriteProperty;
use Tests\DummyNumber;
use Tests\Dummy;
use Tests\DummyInterface;
use ZE\Zval;
use ZE\OpCode;
use ZE\ZendClassEntry;
use ZE\ObjectHandler;

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

    /**
     * @runInSeparateProcess
     */
    public function getCreateObject(): void
    {
        $log = '';
        $this->refClass->createObject(function (CreateObject $hook) use (&$log) {
            $log    .= 'Before initialization.' . PHP_EOL;
            $object = $hook->continue();
            $log    .= 'After initialization.';

            return $object;
        });

        $instance = new Dummy();
        // We should get instance of our original object, because we are calling default handler
        var_dump($instance instanceof Dummy);
        var_dump($log);
    }

    public function getInterfaceGetsImplemented(): void
    {
        $log = '';
        $refInterface = new ZendClassEntry(DummyInterface::class);
        $refInterface->interfaceGetsImplemented(function (InterfaceGetsImplemented $hook) use (&$log) {
            $log = 'Class ' . $hook->get_class()->getName() . ' implements interface';

            return \ZE::SUCCESS;
        });

        // Check that log line is empty now
        var_dump('' === $log);

        // Now we expect that at this point of time our callback will be called
        $anonymousInterfaceImplementation = new class implements DummyInterface
        {
        };

        // Of course, we should get an instance of our DummyInterface
        var_dump($anonymousInterfaceImplementation instanceof DummyInterface);

        // ... and log entry will contain a record about anonymous class that implements interface
        //'@anonymous'
        var_dump($log);
    }

    /**
     * @runInSeparateProcess
     */
    public function getCastObject(): void
    {
        $handler = Closure::fromCallable([ObjectHandler::class, '__init']);
        $this->refClass->createObject($handler);
        $this->refClass->castObject(function (CastObject $hook) {
            $castType = $hook->cast_type();
            switch ($castType) {
                case \ZE::IS_LONG:
                case \ZE::_IS_NUMBER:
                    return 1;
                case \ZE::IS_DOUBLE:
                    return 2.0;
                case \ZE::IS_STRING:
                    return 'test';
                case \ZE::_IS_BOOL:
                    return false;
            }
            throw new \UnexpectedValueException("Unknown type " . Zval::name($castType));
        });

        $testClass = new Dummy();
        $long = (int)$testClass;
        var_dump(1 === $long);

        $double = (float)$testClass;
        var_dump(2.0 === $double);

        $string = (string)$testClass;
        var_dump('test' === $string);

        $bool = (bool)$testClass;
        var_dump(false === $bool);
    }

    /**
     * @runInSeparateProcess
     */
    public function getReadProperty(): void
    {
        $handler = Closure::fromCallable([ObjectHandler::class, '__init']);
        $this->refClass->createObject($handler);
        $this->refClass->readProperty(function (ReadProperty $hook) {
            $value = $hook->continue();
            return $value * 2;
        });
        $instance = new Dummy();
        $value = $instance->property;
        var_dump(42 != $value);
        var_dump(42 * 2 === $value);

        $secret = $instance->tellSecret();
        var_dump(100500 * 2 === $secret);
    }

    /**
     * @runInSeparateProcess
     */
    public function getWriteProperty(): void
    {
        $handler = Closure::fromCallable([ObjectHandler::class, '__init']);
        $this->refClass->createObject($handler);
        $this->refClass->writeProperty(function (WriteProperty $hook) {
            // We can change value, for example by multiply it
            return $hook->value() * 2;
        });
        $instance = new Dummy();
        $instance->property = 10;
        var_dump(42 !== $instance->property);
        var_dump(20 === $instance->property);

        $instance->setSecret(200);
    }

    /**
     * @runInSeparateProcess
     */
    public function getUnsetProperty(): void
    {
        $logEntry = '';
        $handler  = Closure::fromCallable([ObjectHandler::class, '__init']);
        $this->refClass->createObject($handler);
        $this->refClass->unsetProperty(function (UnsetProperty $hook) use (&$logEntry) {
            // do nothing, so property will exist
            $logEntry = $hook->member_name();
        });
        $instance = new Dummy();
        unset($instance->property);

        // Property should remain
        var_dump(property_exists($instance, 'property'));

        // Hook should be called and we will receive the property name
        var_dump('property' === $logEntry);
    }

    /**
     * @runInSeparateProcess
     */
    public function getHasProperty(): void
    {
        $logEntry = '';
        $handler  = Closure::fromCallable([ObjectHandler::class, '__init']);
        $this->refClass->createObject($handler);
        $this->refClass->hasProperty(function (HasProperty $hook) use (&$logEntry) {
            $logEntry = $hook->member_name();
            // Let's inverse presence of field :)
            return (int)(!$hook->continue());
        });

        $instance = new Dummy();
        var_dump(isset($instance->property) === false);
        var_dump('property', $logEntry);
        var_dump(isset($instance->unknown) === true);
        var_dump('unknown' === $logEntry);
    }

    /**
     * @runInSeparateProcess
     */
    public function getGetPropertiesFor(): void
    {
        $handler = Closure::fromCallable([ObjectHandler::class, '__init']);
        $this->refClass->createObject($handler);
        $this->refClass->getPropertiesFor(function (GetPropertiesFor $hook) {
            var_dump(is_object($hook->object()));
            return ['a' => 1, 'b' => true, 'c' => 42.0];
        });

        $instance = new Dummy();
        $instance->property = 10;
        $castValue = (array) $instance;

        // We expect that our handler is called, thus no existing public fields will be returned
        var_dump(!array_key_exists('property', $castValue));

        // Instead we can control how to cast object to array
        var_dump(['a' => 1, 'b' => true, 'c' => 42.0] === $castValue);
    }

    /**
     * @runInSeparateProcess
     */
    public function getCompareValues(): void
    {
        $handler = Closure::fromCallable([ObjectHandler::class, '__init']);
        $this->refClass->createObject($handler);
        $this->refClass->compareValues(function (CompareValues $hook) {
            $left  = $hook->op1();
            $right = $hook->op2();
            if (is_object($left)) {
                $left = spl_object_id($left);
            }
            if (is_object($right)) {
                $right = spl_object_id($right);
            }

            return $left <=> $right;
        });

        $first = new Dummy();
        $second = new Dummy();

        $firstId = spl_object_id($first);
        $secondId = spl_object_id($second);

        // As we compare values by object_id, then we should expect same values as simple int comparison
        var_dump(($firstId < $secondId) === ($first < $second));
        var_dump(($firstId == $secondId) === ($first == $second));
        var_dump(($firstId >= $secondId) === ($first >= $second));

        // We can also compare objects with values directly, look at $secondId arg
        var_dump($firstId < $secondId === $first < $secondId);
        var_dump($firstId > $secondId === $firstId > $second);
    }

    /**
     * @runInSeparateProcess
     */
    public function getDoOperation(): void
    {
        $handler = Closure::fromCallable([ObjectHandler::class, '__init']);
        $this->refClass->createObject($handler);
        $this->refClass->doOperation(function (DoOperation $hook) {
            $opCode = $hook->opcode();
            $left   = $hook->op1();
            $right  = $hook->op2();

            if (is_object($left)) {
                $left = spl_object_id($left);
            }
            if (is_object($right)) {
                $right = spl_object_id($right);
            }
            switch ($opCode) {
                case OpCode::ADD:
                    return $left + $right;
                case OpCode::SUB:
                    return $left - $right;
                case OpCode::MUL:
                    return $left * $right;
                case OpCode::DIV:
                    return $left / $right;
            }
            throw new \UnexpectedValueException("Opcode " . OpCode::name($opCode) . " wasn't held.");
        });

        /** @var int|object */
        $first = new Dummy();

        /** @var int|object */
        $second = new Dummy();

        $firstId  = spl_object_id($first);
        $secondId = spl_object_id($second);

        // As we compare values by object_id, then we should expect same values as simple int comparison
        var_dump($firstId + $secondId === $first + $second);
        var_dump($firstId - $secondId === $first - $second);
        var_dump($firstId * $secondId === $first * $second);
        var_dump($firstId / $secondId === $first / $second);
    }


    public function getExtension(): void
    {
        $refClass = new ZendClassEntry(DummyNumber::class);
        $refClass->install_handlers();

        /** @var int */
        $a = new DummyNumber(46);

        /** @var int */
        $b = new DummyNumber(2);

        $c = $a + $b;
        var_dump(48 === (int) $c);

        $d = $a / $b;
        var_dump(23.0 === (float) $d);

        $e = $a > 10 && $a < 50;
        // 'Number should be equal to 46'
        var_dump($e == -true);

        $f = ($a * 2) < 100;
        // '46*2=92 is less than 100'
        var_dump($f === true);
    }

    public function run()
    {
        $this->getCreateObject();
    }
}

$Test = new Entry();
$Test->run();
