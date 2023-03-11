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

        $pthread[$i] = \pthread_init();
        $status = $pthread[$i]->create(function (int $index) {
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

        if ($status != 0) {
            fprintf(STDERR, "pthread_create() failed [status: %d]\n", $status);
            return 0;
        }
    }

    for ($i = 0; $i < MAX_THREADS; $i++) {
        printf("[Array Index: %d] Waiting for the child thread..\n", $index[$i]);
        $status = $pthread[$i]->join();
        if ($status != 0) {
            fprintf(STDERR, "pthread_join() failed [status: %d]\n", $status);
        }
        printf("[Array Index: %d] Child thread is done\n", $index[$i]);
    }
}

main();
