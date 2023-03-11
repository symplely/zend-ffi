<?php

use FFI\CData;
use ZE\Zval;
use ZE\PThread;
use ZE\Thread;

require 'vendor/autoload.php';

threads_customize(
    function (int $type, int $module_number): int {
        echo 'module_startup' . \PHP_EOL;
        return \ZE::SUCCESS;
    },
    function (int $type, int $module_number): int {
        echo 'module_shutdown' . \PHP_EOL;
        return \ZE::SUCCESS;
    },
    function (int $type, int $module_number): int {
        echo 'request_startup' . \PHP_EOL;
        return \ZE::SUCCESS;
    },
    function (int $type, int $module_number): int {
        echo 'request_shutdown' . \PHP_EOL;
        return \ZE::SUCCESS;
    },
    function (\FFI\CData $memory): void {
        echo 'global_startup' . \PHP_EOL;
    },
    function (\FFI\CData $memory): void {
        echo 'global_shutdown' . \PHP_EOL;
    }
);

// example from http://codingbison.com/c/c-pthreads-basics.html

define('MAX_THREADS', 3);

function main()
{
    $arrPaintings = [
        "The Last Supper", "Mona Lisa", "Potato Eaters",
        "Cypresses", "Starry Night", "Water Lilies"
    ];

    $status = 0;
    $arrLen = ffi_sizeof($arrPaintings) * \count($arrPaintings);

    srand(time());                  /* initialize random seed */
    for ($i = 0; $i < MAX_THREADS; $i++) {
        $index[$i] = rand() % $arrLen;     /* Generate a random number less than arrLen */

        printf("[Array Index: %d] Starting the child thread..\n", $index[$i]);

        $pthread[$i] = \c_typedef('php_thread', 'ts');
        $pthread[$i]()->function = function (CData $arg) {
            if (!\function_exists('zend_preloader'))
                include_once 'preload.php';

            /** @var Thread|PThread */
            $thread = \thread_startup(\zval_native_cast('zval*', $arg));

            if (!$thread instanceof PThread) {
                $status = $thread->wait();
                while ($status === \ZE::SUCCESS && !$thread->empty()) {
                    $thread->execute();
                }
            } else {
                $thread->execute();
            }

            $exception = \zend_eg('exception');
            if (\is_cdata($exception))
                \ze_ffi()->zend_exception_error($exception, \E_ERROR);

            \thread_shutdown($thread);

            return NULL;
        };

        $thread[$i] = \thread_init();
        $thread[$i]->add(function (int $index) {
            $arrPaintings = [
                "The Last Supper", "Mona Lisa", "Potato Eaters",
                "Cypresses", "Starry Night", "Water Lilies"
            ];

            printf("\t[Array Index: %d] Going to sleep..\n", $index);
            sleep(10);
            printf(
                "\t[Array Index: %d] Woke up. Painting: %s\n",
                $index,
                $arrPaintings[$index]
            );

            return 0;
        }, $index[$i]);

        $thread[$i]->set_thread($pthread[$i]()->thread);
        $pthread[$i]()->arg = \ffi_void(\zval_constructor($thread[$i])());

        $status = ts_ffi()->pthread_create(
            $pthread[$i]->addr('thread'),
            null,
            function (CData $arg) {
                if (!\function_exists('zend_preloader'))
                    include_once 'preload.php';

                /** @var Thread|PThread */
                $thread = \thread_startup(\zval_native_cast('zval*', $arg));

                if (!$thread instanceof PThread) {
                    $status = $thread->wait();
                    while ($status === \ZE::SUCCESS && !$thread->empty()) {
                        $thread->execute();
                    }
                } else {
                    $thread->execute();
                }

                $exception = \zend_eg('exception');
                if (\is_cdata($exception))
                    \ze_ffi()->zend_exception_error($exception, \E_ERROR);

                \thread_shutdown($thread);

                return NULL;
            },
            $pthread[$i]()->arg
        );

        if ($status != 0) {
            fprintf(STDERR, "pthread_create() failed [status: %d]\n", $status);
            return 0;
        }
    }

    for ($i = 0; $i < MAX_THREADS; $i++) {
        printf("[Array Index: %d] Waiting for the child thread..\n", $index[$i]);
        $status = $thread[$i]->join();
        if ($status != 0) {
            fprintf(STDERR, "pthread_join() failed [status: %d]\n", $status);
        }
        printf("[Array Index: %d] Child thread is done\n", $index[$i]);
    }
}

main();
