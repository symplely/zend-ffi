<?php

declare(strict_types=1);

namespace ZE;

use ZE\ZendString;
use ZE\Ast\ZendAst;

if (!\class_exists('ZendCompiler')) {
    final class ZendCompiler extends \ZE
    {
        protected $isZval = false;

        const COMPILE_EXTENDED_STMT  = (1 << 0);
        const COMPILE_EXTENDED_FCALL = (1 << 1);
        const COMPILE_EXTENDED_INFO  = (self::COMPILE_EXTENDED_STMT | self::COMPILE_EXTENDED_FCALL);

        /** call op_array handler of extendions */
        const COMPILE_HANDLE_OP_ARRAY = (1 << 2);

        /** generate INIT_FCALL_BY_NAME for internal functions instead of INIT_FCALL */
        const COMPILE_IGNORE_INTERNAL_FUNCTIONS = (1 << 3);

        /** don't perform early binding for classes inherited form internal ones;
         * in namespaces assume that internal class that doesn't exist at compile-time
         * may apper in run-time */
        const COMPILE_IGNORE_INTERNAL_CLASSES = (1 << 4);

        /** generate DECLARE_CLASS_DELAYED opcode to delay early binding */
        const COMPILE_DELAYED_BINDING = (1 << 5);

        /** disable constant substitution at compile-time */
        const COMPILE_NO_CONSTANT_SUBSTITUTION = (1 << 6);

        /** disable usage of builtin instruction for strlen() */
        const COMPILE_NO_BUILTIN_STRLEN = (1 << 7);

        /** disable substitution of persistent constants at compile-time */
        const COMPILE_NO_PERSISTENT_CONSTANT_SUBSTITUTION = (1 << 8);

        /** generate INIT_FCALL_BY_NAME for userland functions instead of INIT_FCALL */
        const COMPILE_IGNORE_USER_FUNCTIONS = (1 << 9);

        /** force ACC_USE_GUARDS for all classes */
        const COMPILE_GUARDS = (1 << 10);

        /** disable builtin special case function calls */
        const COMPILE_NO_BUILTINS = (1 << 11);

        /** result of compilation may be stored in file cache */
        const COMPILE_WITH_FILE_CACHE = (1 << 12);

        /** ignore functions and classes declared in other files */
        const COMPILE_IGNORE_OTHER_FILES = (1 << 13);

        /** this flag is set when compiler invoked by opcache_compile_file() */
        const COMPILE_WITHOUT_EXECUTION = (1 << 14);

        /** this flag is set when compiler invoked during preloading */
        const COMPILE_PRELOAD = (1 << 15);

        /** disable jumptable optimization for switch statements */
        const COMPILE_NO_JUMPTABLES = (1 << 16);

        /** this flag is set when compiler invoked during preloading in separate process */
        const COMPILE_PRELOAD_IN_CHILD = (1 << 17);

        /** The default value for CG(compiler_options) */
        const COMPILE_DEFAULT = self::COMPILE_HANDLE_OP_ARRAY;

        /** The default value for CG(compiler_options) during eval() */
        const COMPILE_DEFAULT_FOR_EVAL = 0;

        /**
         * Represents `CG(compiler_globals)` _macro_.
         *
         * @return self
         */
        public static function init(): ZendCompiler
        {
            return static::init_value(static::compiler_globals());
        }

        /**
         * Returns a `HashTable` with all registered classes
         *
         * @return HashTable|Zval[]
         */
        public static function class_table(): HashTable
        {
            return HashTable::init_value(static::compiler_globals()->class_table);
        }

        public static function auto_globals(): HashTable
        {
            return HashTable::init_value(static::compiler_globals()->auto_globals);
        }

        /**
         * Returns a `HashTable` with all registered functions
         *
         * @return HashTable|Zval[]
         */
        public static function function_table(): HashTable
        {
            return HashTable::init_value(static::compiler_globals()->function_table);
        }

        /**
         * Checks if engine is in compilation mode or not
         *
         * @param boolean|null $enabled Enables or disables compilation mode
         * @return boolean|void
         */
        public function in_compilation(bool $enabled = null)
        {
            if (\is_null($enabled))
                return (bool) $this->ze_other_ptr->in_compilation;

            $this->ze_other_ptr->in_compilation = (int) $enabled;
        }

        /**
         * Returns the Abstract Syntax Tree for given source file
         */
        public function get_ast(): ZendAst
        {
            if ($this->ze_other_ptr->ast === null) {
                throw new \LogicException('Not in compilation process');
            }

            return ZendAst::factory($this->ze_other_ptr->ast);
        }

        /**
         * Returns the file name which is compiled at the moment
         */
        public function compiled_filename(): string
        {
            if ($this->ze_other_ptr->compiled_filename === null) {
                throw new \LogicException('Not in compilation process');
            }

            return ZendString::init_value($this->ze_other_ptr->compiled_filename)->value();
        }

        /**
         * Returns current compiler options, or configures compiler options
         *
         * @param int $newOptions See COMPILER_xxx constants in this class
         * @return int|void
         */
        public function compiler_options(int $newOptions = null)
        {
            if (\is_null($newOptions))
                return $this->ze_other_ptr->compiler_options;

            $this->ze_other_ptr->compiler_options = $newOptions;
        }

        /**
         * Performs parsing of PHP source code into the AST
         *
         * @param string $source Source code to parse
         * @param string $fileName Optional filename that will be used in the engine
         *
         * @return ZendAst
         */
        public function parse_string(string $source, string $fileName = ''): ZendAst
        {
            $sourceValue = ZendString::init($source);
            if (\IS_PHP74) {
                $sourceRaw = $sourceValue();
                $rawSourceVal = Zval::new(\ZE::IS_STRING, $sourceRaw)();
                $originalLexState = \ze_ffi()->new('zend_lex_state');
                $originalCompilationMode = $this->in_compilation();
                $this->in_compilation(true);

                \ze_ffi()->zend_save_lexical_state(\FFI::addr($originalLexState));
                $result = \ze_ffi()->zend_prepare_string_for_scanning($rawSourceVal, \ffi_char($fileName));
                if ($result === \ZE::SUCCESS) {
                    $this->ze_other_ptr->ast = null;
                    $this->ze_other_ptr->ast_arena = $this->createArena(1024 * 32);
                    $result = \ze_ffi()->zendparse();
                    if ($result !== \ZE::SUCCESS) {
                        \ze_ffi()->zend_ast_destroy($this->ze_other_ptr->ast);
                        $this->ze_other_ptr->ast = null;
                        \FFI::free($this->ze_other_ptr->ast_arena);
                        $this->ze_other_ptr->ast_arena = null;
                    }
                }

                // restore_lexical_state changes CG(ast) and CG(ast_arena)
                $ast = $this->ze_other_ptr->ast;

                \ze_ffi()->zend_restore_lexical_state(\FFI::addr($originalLexState));
                $this->in_compilation($originalCompilationMode);
            } else {
                $file = ((float) \phpversion()) >= 8.1
                    ? \FFI::addr(ZendString::init($fileName)()) : $fileName;

                $arena = \FFI::addr(\ze_ffi()->new("zend_arena*", false));
                $ast = \ze_ffi()->zend_compile_string_to_ast(
                    \FFI::addr($sourceValue()),
                    $arena,
                    $file
                );

                $this->ze_other_ptr->ast = $ast;
                $this->ze_other_ptr->ast_arena = $arena[0];
            }

            $node = ZendAst::factory($ast);

            return $node;
        }

        /**
         * Creates an arena for misc needs
         *
         * @param int $size Size of arena to create
         * @see zend_arena.h:zend_arena_create
         */
        private function createArena(int $size): \FFI\CData
        {
            $rawBuffer = \ze_ffi()->new("char[$size]", false);
            $arena = \ze_ffi()->cast('zend_arena *', $rawBuffer);

            $arena->ptr = $rawBuffer + self::aligned_size(\FFI::sizeof(\ze_ffi()->type('zend_arena')));
            $arena->end = $rawBuffer + $size;
            $arena->prev = null;

            return $arena;
        }
    }
}
