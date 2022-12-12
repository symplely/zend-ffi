<?php

use FFI\CData;
use ZE\Zval;

require 'vendor/autoload.php';

$module = threads_customization(
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
        if (\PHP_ZTS) {
            \tsrmls_activate();
        }

        echo 'global_startup' . \PHP_EOL;
        //  \FFI::memset($module->get_globals(), 0, $module->globals_size());
    },
    function (\FFI\CData $memory): void {
        echo 'global_shutdown' . \PHP_EOL;
    },
    'unsigned int[10]'
);

$module->destruct_set();

// example from https://learn.microsoft.com/en-us/windows/win32/procthread/creating-threads

define('MAX_THREADS', 3);
define('BUF_SIZE', 255);


function _tmain(\ThreadsModule $module)
{
    $MyThreadFunction = function (CData $lpParam) use ($module) {
        print "     in thread ---------------------";
        // $module->thread_startup(null);
        // Cast the parameter to the correct data type.
        // The pointer is known to be valid because
        // it was checked for NULL before the thread was created.
        $pDataArray = ffi_get('temp')->cast('PMYDATA*', $lpParam);

        // Print the parameter values using thread-safe functions.
        printf("Parameters = %d, %d\n", $pDataArray->val1, $pDataArray->val2);
        // $module->thread_shutdown();
        return 0;
    };

    // Allocate memory for thread data.
    $pDataArray = c_array_type('MYDATA', 'temp', MAX_THREADS);
    if (\is_null($pDataArray())) {
        // If the array allocation fails, the system is out of memory
        // so there is no point in trying to print an error message.
        // Just terminate execution.
        ze_ffi()->_zend_bailout(__FILE__, __LINE__);
    }

    $hThreadArray = c_array_type('HANDLE', 'ze', MAX_THREADS);

    // Create MAX_THREADS worker threads.
    for ($i = 0; $i < MAX_THREADS; $i++) {
        $dwThreadIdArray[$i] = c_int_type('DWORD');
        // Generate unique data for each thread to work with.

        $pDataArray()[$i]->val1 = $i;
        $pDataArray()[$i]->val2 = $i + 100;

        print("Creating Thread ");
        // Create the thread to begin execution on its own.
        $hThreadArray()[$i] = win_ffi()->CreateThread(
            NULL,                   // default security attributes
            0,                      // use default stack size
            $MyThreadFunction,      // thread function name
            win_ffi()->cast('LPVOID', $pDataArray()[$i]), // argument to thread function
            0,                      // use default creation flags
            $dwThreadIdArray[$i]()  // returns the thread identifier
        );

        print 'returned id: ' . $dwThreadIdArray[$i]->value() . PHP_EOL;
        // Check the return value for success.
        // If CreateThread fails, terminate execution.
        // This will automatically clean up threads and memory.
        if (\is_null($hThreadArray()[$i])) {
            print("CreateThread Failed");
            win_ffi()->ExitProcess(3);
        }
    } // End of main thread creation loop.

    // Wait until all threads have terminated.
    $dword = win_ffi()->WaitForMultipleObjects(MAX_THREADS, $hThreadArray(), TRUE, 1);
    // win_ffi()->WaitForSingleObject($hThreadArray()[1], \ZE::INFINITE);
    printf("CreateEvent error: %d\n", $dword);
    // Close all thread handles and free memory allocations.
    for ($i = 0; $i < MAX_THREADS; $i++) {
        win_ffi()->CloseHandle($hThreadArray()[$i]);
        ffi_free_if($pDataArray()[$i]); // Ensure address is not reused.
    }

    return 0;
}

ffi_set(
    'temp',
    ffi_cdef('typedef struct MyData
{
	int val1;
	int val2;
} MYDATA, *PMYDATA;')
);

$pDataArray = c_array_type('MYDATA', 'temp', MAX_THREADS);
_tmain($module);
