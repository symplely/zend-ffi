<?php

/**
 * Z-Engine framework
 *
 * @copyright Copyright 2020, Lisachenko Alexander <lisachenko.it@gmail.com>
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE.
 *
 */

declare(strict_types=1);

namespace ZE\Hook;

use ZE\Zval;
use ZE\ZendExecutor;
use ZE\Hook\AbstractProperty;

/**
 * Receiving hook for casting to array, debugging, etc
 */
class GetPropertiesFor extends AbstractProperty
{
    protected const HOOK_FIELD = 'get_properties_for';

    /**
     * typedef `zend_array` *(*zend_object_get_properties_for_t)(zend_object *object, zend_prop_purpose purpose);
     *
     * @inheritDoc
     */
    public function handle(...$c_args)
    {
        [$this->object, $this->purpose] = $c_args;

        $result = ($this->userHandler)($this);
        $refValue = Zval::init_value($result);

        return $refValue->arr();
    }

    /**
     * Returns the purpose
     */
    public function purpose(): int
    {
        return $this->purpose;
    }

    /**
     * Proceeds with default handler
     */
    public function continue()
    {
        if (!$this->has_original()) {
            throw new \LogicException('Original handler is not available');
        }

        // As we will play with EG(fake_scope), we won't be able to access private or protected members, need to unpack
        $originalHandler = $this->originalHandler;

        $object = $this->object;
        $purpose = $this->purpose;

        $previousScope = ZendExecutor::init()->fake_scope($object->ce);
        $result = ($originalHandler)($object, $purpose);
        ZendExecutor::init()->fake_scope($previousScope);

        return $result;
    }
}
