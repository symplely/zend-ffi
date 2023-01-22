<?php

declare(strict_types=1);

namespace ZE;

use ZE\Zval;
use ZE\ZendExecutor;

if (!\class_exists('ZendReference')) {
    /**
     * Class `ZendReference` represents a reference instance in PHP
     *```c++
     * struct _zend_reference {
     *     zend_refcounted_h              gc;
     *     zval                           val;
     *     zend_property_info_source_list sources;
     * };
     *```
     */
    final class ZendReference extends \ZE
    {
        protected $isZval = false;

        public static function init(&$reference): ZendReference
        {
            $current = ZendExecutor::init()->call_argument(0);
            if ($current()->u1->v->type !== \ZE::IS_REFERENCE) {
                return \ze_ffi()->zend_error(\E_WARNING, 'Reference creation available only for the type IS_REFERENCE');
            }

            return static::init_value($current()->value->ref);
        }

        /**
         * Returns the internal value, stored for this reference
         */
        public function internal_value(): Zval
        {
            return \zend_value($this->ze_other_ptr->val);
        }

        public function __debugInfo(): array
        {
            $info = [
                'refcount' => $this->gc_refcount(),
                'value'    => $this->internal_value()
            ];

            return $info;
        }
    }
}
