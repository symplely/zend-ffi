<?php

declare(strict_types=1);

namespace ZE;

use ZE\HashTable;

if (!\class_exists('TsHashTable')) {
    /**
     * Class `TsHashTable` provides `Thread` general access to the internal array objects, aka hash-table
     *```c++
     * typedef struct _zend_ts_hashtable {
     *	HashTable hash;
     *	uint32_t reader;
     *	pthread_mutex_t *mx_reader;
     *	pthread_mutex_t *mx_writer;
     * } TsHashTable;
     *```
     */
    class TsHashTable extends HashTable
    {
        public static function module_registry()
        {
            return static::init_value(\ffi_ptr(\ze_ffi()->module_registry));
        }
    }
}
