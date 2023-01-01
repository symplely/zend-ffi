<?php

declare(strict_types=1);

namespace ZE\Hook;

use FFI\CData;
use ZE\ZendClassEntry;
use ZE\ObjectHandler;

/**
 * Receiving hook for performing operation on object
 */
class CreateObject extends ObjectHandler
{
    protected const HOOK_FIELD = 'create_object';

    /**
     * typedef `zend_object` *(*create_object)(zend_class_entry *class_type);
     */
    public function handle(...$c_args): CData
    {
        [$this->classType] = $c_args;

        return ($this->userHandler)($this);
    }

    /**
     * Returns a `C data` class type (zend_class_entry)
     *
     * @param CData|null $classType Changes a class type to create
     * @return CData|void
     */
    public function class_type(CData $classType = null)
    {
        if (\is_null($classType))
            return $this->classType;

        $this->classType = $classType;
    }

    /**
     * Proceeds with object creation
     */
    public function continue()
    {
        if ($this->originalHandler === null) {
            $object = ZendClassEntry::newInstance($this->classType);
        } else {
            $object = ($this->originalHandler)($this->classType);
        }

        return $object;
    }
}
