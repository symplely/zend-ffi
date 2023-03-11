<?php

declare(strict_types=1);

namespace ZE;

use Closure;
use ZE\Thread;
use FFI\CData;
use ZE\Zval;

if (\PHP_ZTS && !\class_exists('PThread')) {
    final class PThread
    {
        /** @var \php_thread */
        private ?\CStruct $thread = null;

        private ?Closure $func = null;
        private ?\ThreadsModule $module = null;

        public function get_module(): ?\ThreadsModule
        {
            return $this->module;
        }

        public function __invoke(): ?CData
        {
            return $this->thread->__invoke();
        }

        public function __construct(\ThreadsModule $module)
        {
            $this->module = $module;
            $this->thread = \c_typedef('php_thread', 'ts');
        }

        public function execute()
        {
        }
    }
}
