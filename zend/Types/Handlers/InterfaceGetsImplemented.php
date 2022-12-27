<?php

declare(strict_types=1);

namespace ZE\Hook;

use ZE\ObjectHandler;
use ZE\ZendClassEntry;

/**
 * Receiving hook for interface implementation
 */
class InterfaceGetsImplemented extends ObjectHandler
{
    protected const HOOK_FIELD = 'interface_gets_implemented';

    /**
     * typedef `int` (*interface_gets_implemented)(zend_class_entry *iface, zend_class_entry *class_type);
     *
     * @inheritDoc
     */
    public function handle(...$c_args): int
    {
        [$this->interfaceType, $this->classType] = $c_args;

        $result = ($this->userHandler)($this);

        return $result;
    }

    /**
     * Returns a class that implements interface
     */
    public function get_class(): ZendClassEntry
    {
        return ZendClassEntry::init_value($this->classType);
    }

    /**
     * Proceeds with default handler
     */
    public function continue()
    {
        if (!$this->has_original()) {
            throw new \LogicException('Original handler is not available');
        }

        $result = ($this->originalHandler)($this->interfaceType, $this->classType);

        return $result;
    }
}
