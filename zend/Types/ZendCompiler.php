<?php

declare(strict_types=1);

namespace ZE;

if (!\class_exists('ZendCompiler')) {
    final class ZendCompiler extends \ZE
    {
        protected $isZval = false;

        /**
         * Represents `CG(compiler_globals)` _macro_.
         *
         * @return self
         */
        public static function init(): ZendCompiler
        {
            return static::init_value(static::compiler_globals());
        }

        public static function class_table(): HashTable
        {
            return HashTable::init_value(static::compiler_globals()->class_table);
        }

        /**
         * Returns a `HashTable` with all registered functions
         *
         * @return HashTable
         */
        public static function function_table(): HashTable
        {
            return HashTable::init_value(static::compiler_globals()->function_table);
        }
    }
}
