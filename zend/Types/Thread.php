<?php

declare(strict_types=1);

namespace ZE;

use FFI\CData;
use ZE\Zval;

if (\PHP_ZTS && !\class_exists('Thread')) {
    class Thread
    {
        private ?CData $server_context = null;

        /** @var \CStruct|CData|CData|\TValue|<> */
        private ?\SplQueue $worker = null;

        /** @var \MUTEX_T */
        private ?CData $worker_mutex = null;

        /** @var \zend_thread_t */
        private ?\CStruct $thread = null;

        private ?\ThreadsModule $manager = null;

        final public function add(callable $routine, ...$arguments)
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
                $this->push($worker, $fci, $fcc, $value);
                return $value;
            } else {
                \ze_ffi()->zend_error(\E_WARNING, "Failed to add routine!");
            }
        }

        public function execute()
        {
            /** @var \CStruct|CData|CData|\TValue */
            [$thread, $fci, $fcc, $value] = $this->pop();
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

        final protected function pop(): array
        {
            \ze_ffi()->tsrm_mutex_lock($this->worker_mutex);
            $worker = $this->worker->dequeue();
            \ze_ffi()->tsrm_mutex_unlock($this->worker_mutex);

            return $worker;
        }

        final protected function push(\CSTruct $worker, CData $finfo, CData $fcall, \TValue $result): void
        {
            if (\is_typeof($worker(), 'struct _zend_thread_t*')) {
                \ze_ffi()->tsrm_mutex_lock($this->worker_mutex);
                $this->worker->enqueue([$worker, $finfo, $fcall, $result]);
                \ze_ffi()->tsrm_mutex_unlock($this->worker_mutex);
            } else {
                \ffi_free_if($finfo, $fcall);
                \ze_ffi()->zend_error(\E_WARNING, "Not a thread object!");
            }
        }

        public function __destruct()
        {
            if (!$this->empty())
                $this->join();

            unset($this->worker);
            $this->worker = null;
            \ze_ffi()->tsrm_mutex_free($this->worker_mutex);
            $this->worker_mutex = null;
            \ffi_free_if($this->server_context);

            $this->thread = null;
            $this->manager = null;
        }

        public function __construct(\ThreadsModule $module)
        {
            $this->manager = $module;
            $this->worker_mutex = \ze_ffi()->tsrm_mutex_alloc();
            $this->worker = new \SplQueue();
            $this->thread = \c_typedef('zend_threads_t');
            $this->thread->__invoke()->parent->server = \zend_sg('server_context');
        }

        /**
         *```c++
         *typedef struct _zend_threads_t
         *{
         *	THREAD_T *tid;
         *	struct
         *	{
         *		void *server;
         *	} parent;
         *	volatile int num_threads_alive;	  // threads currently alive
         *	volatile int num_threads_working; // threads currently working
         *	MUTEX_T worker_mutex;
         *	COND_T worker_all_idle;
         *	int state;
         *} zend_threads_t;
         *```
         * @return CData|null
         */
        final public function __invoke(): ?CData
        {
            return $this->thread->__invoke();
        }

        /**
         * Number of items in the `worker` queue.
         *
         * @return integer
         */
        public function size(): int
        {
            return $this->worker->count();
        }

        /**
         * Return `True` if the `worker` queue is empty, `False` otherwise.
         *
         * @return bool
         */
        public function empty(): bool
        {
            return $this->worker->isEmpty();
        }

        public function join()
        {
        }

        public function wait()
        {
        }

        public function start()
        {
        }
    }
}
