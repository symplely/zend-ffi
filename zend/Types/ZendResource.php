<?php

declare(strict_types=1);

namespace ZE;

use FFI\CData;
use ZE\Zval;

if (!\class_exists('ZendResource')) {
    /**
     * Class `ZendResource` represents a resource instance in PHP
     *```c++
     * struct _zend_resource {
     *     zend_refcounted_h gc;
     *     int               handle;
     *     int               type;
     *     void             *ptr;
     * };
     *```
     */
    final class ZendResource extends \ZE
    {
        protected $isZval = false;

        public static function init($argument): ZendResource
        {
            return static::init_value(
                Zval::constructor($argument)->res()
            );
        }

        /**
         * Returns the internal type identifier for this resource.
         *
         * @param int $newType - Changes the internal type identifier for this resource
         * - Low-level API, can bring a segmentation fault
         * @return int|void
         * @internal
         */
        public function type(int $newType = null)
        {
            if (\is_null($newType))
                return $this->ze_other_ptr->type;

            $this->ze_other_ptr->type = $newType;
        }

        /**
         * Returns a resource handle.
         *
         * @param int $newHandle Changes object internal handle to another one
         * @return int|void
         * @internal
         */
        public function handle(int $newHandle = null)
        {
            if (\is_null($newHandle))
                return $this->ze_other_ptr->handle;

            $this->ze_other_ptr->handle = $newHandle;
        }

        /**
         * Returns the low-level raw data, associated with this resource.
         */
        public function ptr(): CData
        {
            return  $this->ze_other_ptr->ptr;
        }

        public function __debugInfo(): array
        {
            $info = [
                'type'     => $this->type(),
                'handle'   => $this->handle(),
                'refcount' => $this->gc_refcount(),
                'data'     => $this->ptr()
            ];

            return $info;
        }
    }
}
