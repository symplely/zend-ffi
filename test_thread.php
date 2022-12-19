<?php

use FFI\CData;
use ZE\Zval;

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
    function (...$args): int {
        echo 'request_startup' . \PHP_EOL;
        return \ZE::SUCCESS;
    },
    function (...$args): int {
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

threads_request_destruct();

// example from http://codingbison.com/c/c-pthreads-basics.html

define('MAX_THREADS', 2);

function main()
{
    $arrPaintings = [
        "The Last Supper", "Mona Lisa", "Potato Eaters",
        "Cypresses", "Starry Night", "Water Lilies"
    ];

    $t = c_array_type('pthread_t', 'ts', MAX_THREADS);
    $index = c_array_type('int', 'ze', MAX_THREADS);
    $status = $arrLen = $i = 0;

    $arrLen = ffi_sizeof($arrPaintings);

    srand(time());                  /* initialize random seed */
    for ($i = 0; $i < MAX_THREADS; $i++) {
        $index()[$i] = rand() % $arrLen;     /* Generate a random number less than arrLen */

        printf("[Array Index: %d] Starting the child thread..\n", $index()[$i]);

        $status = ts_ffi()->pthread_create(
            $t->addr_array($i),
            null,
            function (CData $arg) {
                $arrPaintings = [
                    "The Last Supper", "Mona Lisa", "Potato Eaters",
                    "Cypresses", "Starry Night", "Water Lilies"
                ];

                $index = ze_cast('int', $arg);

                printf("\t[Array Index: %d] Going to sleep..\n", $index);
                sleep(10);
                printf(
                    "\t[Array Index: %d] Woke up. Painting: %s\n",
                    $index,
                    $arrPaintings[$index]
                );

                return 0;
            },
            $index->void_array($i)
        );

        if ($status != 0) {
            fprintf(STDERR, "pthread_create() failed [status: %d]\n", $status);
            return 0;
        }
    }

    for ($i = 0; $i < MAX_THREADS; $i++) {
        printf("[Array Index: %d] Waiting for the child thread..\n", $index()[$i]);
        $status = ts_ffi()->pthread_join($t()[$i], NULL);
        if ($status != 0) {
            fprintf(STDERR, "pthread_join() failed [status: %d]\n", $status);
        }
        printf("[Array Index: %d] Child thread is done\n", $index()[$i]);
    }
}

main();
