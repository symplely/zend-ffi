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
        private ?\CStruct $php_thread = null;

        private ?Closure $func = null;
        private ?\ThreadsModule $module = null;
        private array $fcall_info = [];

        /** @var array[CData,CData] */
        private array $interpreter_context = [];

        public function set_contexts(CData $new, CData $old): void
        {
            $this->interpreter_context = [$new, $old];
        }

        public function get_contexts(): array
        {
            return $this->interpreter_context;
        }

        public function get_module(): ?\ThreadsModule
        {
            return $this->module;
        }

        public function get_func(): ?\Closure
        {
            return $this->func;
        }

        public function get_id(): ?CData
        {
            return $this->__invoke()->thread;
        }

        public function get_ptr(): CData
        {
            return $this->php_thread->addr('thread');
        }

        public function get_args(): CData
        {
            return $this->php_thread->__invoke()->arg;
        }

        public function set_args($data = null): void
        {
            $this->php_thread->__invoke()->arg = \ffi_void(\zval_constructor($data)());
        }

        public function __invoke(): ?CData
        {
            return $this->php_thread->__invoke();
        }

        public function __destruct()
        {
            $this->func = null;
            $this->php_thread = null;
            $this->module = null;
            $this->fcall_info = [];
        }

        public function __construct(\ThreadsModule $module)
        {
            $this->module = $module;
            $this->func = function (CData $arg) {
                if (!\function_exists('zend_preloader'))
                    include_once 'preload.php';

                /** @var Thread|PThread */
                $thread = \thread_startup(\zval_native_cast('zval*', $arg));

                if ($thread instanceof PThread) {
                    $thread->execute();
                } else {
                    do {
                        $status = $thread->wait();
                        if ($status !== \ZE::SUCCESS)
                            break;

                        while (!$thread->empty()) {
                            $thread->execute();
                        }
                    } while (true);
                }

                $exception = \zend_eg('exception');
                if (\is_cdata($exception))
                    \ze_ffi()->zend_exception_error($exception, \E_ERROR);

                \thread_shutdown($thread);

                return NULL;
            };

            $this->php_thread = \c_typedef('php_thread', 'ts');
        }

        public function execute()
        {
            /** @var \CStruct|CData|CData|\TValue */
            [$thread, $fci, $fcc, $value] = $this->fcall_info;
            $worker = $thread();
            $ret = \zval_blank();
            if (\ze_ffi()->zend_fcall_info_call($fci, $fcc, $ret(), $worker->args) === 0) {
                \ze_ffi()->zend_release_fcall_info_cache($fcc);
                $value->set(\zval_native($ret), $this->worker_mutex);
            } else {
                \ze_ffi()->zend_error(\E_WARNING, "Failed to execute routine!");
            }

            \ffi_free_if($fci, $fcc);
        }

        protected function add(callable $routine, ...$arguments)
        {
            $callable = \zval_constructor($routine);
            if (!\is_null($arguments))
                $args = \zval_constructor($arguments);
            else
                $args = null;

            $worker = \c_typedef('zend_thread_t');
            $thread = $worker();
            $thread->args = $args instanceof Zval ? $args() : $args;
            $thread->fci->param_count = 0;
            $thread->fci->params = NULL;
            $fci = \FFI::addr($thread->fci);
            $fcc = \FFI::addr($thread->fcc);
            if (\ze_ffi()->zend_fcall_info_init($callable(), 0, $fci, $fcc, null, null) === 0) {
                $value = new \TValue;
                $this->fcall_info = [$worker, $fci, $fcc, $value];
            } else {
                \ze_ffi()->zend_error(\E_WARNING, "Failed to add routine!");
            }
        }

        public function create(callable $routine, ...$args)
        {
            $this->add($routine, ...$args);
            $this->set_args($this);
            return \ts_ffi()->pthread_create(
                $this->get_ptr(),
                null,
                $this->get_func(),
                $this->get_args()
            );
        }

        public function create_ex($params)
        {
            $this->set_args($params);
            return \ts_ffi()->pthread_create(
                $this->get_ptr(),
                null,
                $this->get_func(),
                $this->get_args()
            );
        }

        public function join()
        {
            return \ts_ffi()->pthread_join($this->get_ptr()[0], NULL);
        }
    }
}
