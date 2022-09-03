<?php

declare(strict_types=1);

use FFI\CData;

if (!\class_exists('ZE')) {
    abstract class ZE
    {
        const GC_COLLECTABLE = (1 << 4);
        /** used for recursion detection */
        const GC_PROTECTED = (1 << 5);
        /** can't be changed in place */
        const GC_IMMUTABLE = (1 << 6);
        /** allocated using malloc */
        const GC_PERSISTENT = (1 << 7);
        /** persistent, but thread-local */
        const GC_PERSISTENT_LOCAL = (1 << 8);

        const GC_TYPE_MASK = 0x0000000f;
        const GC_FLAGS_MASK = 0x000003f0;
        const GC_INFO_MASK = 0xfffffc00;
        const GC_FLAGS_SHIFT = 0;
        const GC_INFO_SHIFT = 10;


        const HASH_UPDATE          = (1 << 0);
        const HASH_ADD             = (1 << 1);
        const HASH_UPDATE_INDIRECT = (1 << 2);
        const HASH_ADD_NEW         = (1 << 3);
        const HASH_ADD_NEXT        = (1 << 4);

        /** used for casts */
        const _IS_BOOL                = \IS_PHP74 ? 16 : 17;
        const _IS_NUMBER              = \IS_PHP74 ? 20 : 18;

        const Z_TYPE_MASK             = 0xff;
        const Z_TYPE_FLAGS_MASK       = 0xff00;

        const ZEND_INI_USER         = (1 << 0);
        const ZEND_INI_PERDIR       = (1 << 1);
        const ZEND_INI_SYSTEM       = (1 << 2);
        const ZEND_INI_ALL          = (self::ZEND_INI_USER | self::ZEND_INI_PERDIR | self::ZEND_INI_SYSTEM);

        const ZEND_INI_STAGE_STARTUP        = (1 << 0);
        const ZEND_INI_STAGE_SHUTDOWN       = (1 << 1);
        const ZEND_INI_STAGE_ACTIVATE       = (1 << 2);
        const ZEND_INI_STAGE_DEACTIVATE     = (1 << 3);
        const ZEND_INI_STAGE_RUNTIME        = (1 << 4);
        const ZEND_INI_STAGE_HTACCESS       = (1 << 5);
        const ZEND_INI_STAGE_IN_REQUEST     = (self::ZEND_INI_STAGE_ACTIVATE | self::ZEND_INI_STAGE_DEACTIVATE | self::ZEND_INI_STAGE_RUNTIME | self::ZEND_INI_STAGE_HTACCESS);

        /** Visibility flags (public < protected < private); */
        const ZEND_ACC_PUBLIC =                  (1 <<  0);
        const ZEND_ACC_PROTECTED =               (1 <<  1);
        const ZEND_ACC_PRIVATE =                 (1 <<  2);

        /** Property or method overrides private one   */
        const ZEND_ACC_CHANGED =                 (1 <<  3);

        /** Static method or property       */
        const ZEND_ACC_STATIC =                  (1 <<  4);

        /** Final class or method    */
        const ZEND_ACC_FINAL =                   (1 <<  5);

        /** Abstract method          */
        const ZEND_ACC_ABSTRACT =                (1 <<  6);
        const ZEND_ACC_EXPLICIT_ABSTRACT_CLASS = (1 <<  6);

        /** Immutable op_array and class_entries
         * (implemented only for lazy loading of op_arrays);   */
        const ZEND_ACC_IMMUTABLE =               (1 <<  7);

        /** Function has typed arguments / class has typed props  */
        const ZEND_ACC_HAS_TYPE_HINTS =          (1 <<  8);

        /** Top-level class or function declaration    */
        const ZEND_ACC_TOP_LEVEL =               (1 <<  9);

        /** op_array or class is preloaded  */
        const ZEND_ACC_PRELOADED =               (1 << 10);

        /** Special class types      */
        const ZEND_ACC_INTERFACE =               (1 <<  0);
        const ZEND_ACC_TRAIT =                   (1 <<  1);
        const ZEND_ACC_ANON_CLASS =              (1 <<  2);

        /** Class linked with parent, interfaces and traits     */
        const ZEND_ACC_LINKED =                  (1 <<  3);

        /** Class is abstract, since it is set by any
         * abstract method          */
        const ZEND_ACC_IMPLICIT_ABSTRACT_CLASS = (1 <<  4);

        /** Class has magic methods __get/__set/__unset/
         * __isset that use guards  */
        const ZEND_ACC_USE_GUARDS =              (1 << 11);

        /** Class constants updated  */
        const ZEND_ACC_CONSTANTS_UPDATED =       (1 << 12);

        /** Class extends another class     */
        const ZEND_ACC_INHERITED =               (1 << 13);

        /** Class implements interface(s);  */
        const ZEND_ACC_IMPLEMENT_INTERFACES =    (1 << 14);

        /** Class uses trait(s);     */
        const ZEND_ACC_IMPLEMENT_TRAITS =        (1 << 15);

        /** User class has methods with static variables */
        const ZEND_HAS_STATIC_IN_METHODS =       (1 << 16);

        /** Whether all property types are resolved to CEs */
        const ZEND_ACC_PROPERTY_TYPES_RESOLVED = (1 << 17);

        /** Children must reuse parent get_iterator(); */
        const ZEND_ACC_REUSE_GET_ITERATOR =      (1 << 18);

        /** Parent class is resolved (CE);. */
        const ZEND_ACC_RESOLVED_PARENT =         (1 << 19);

        /** Interfaces are resolved (CEs);. */
        const ZEND_ACC_RESOLVED_INTERFACES =     (1 << 20);

        /** Class has unresolved variance obligations. */
        const ZEND_ACC_UNRESOLVED_VARIANCE =     (1 << 21);

        /** deprecation flag */
        const ZEND_ACC_DEPRECATED =              (1 << 11);

        /** Function returning by reference */
        const ZEND_ACC_RETURN_REFERENCE =        (1 << 12);

        /** Function has a return type      */
        const ZEND_ACC_HAS_RETURN_TYPE =         (1 << 13);

        /** Function with variable number of arguments */
        const ZEND_ACC_VARIADIC =                (1 << 14);

        /** op_array has finally blocks (user only);   */
        const ZEND_ACC_HAS_FINALLY_BLOCK =       (1 << 15);

        /** "main" op_array with
         * ZEND_DECLARE_CLASS_DELAYED opcodes         */
        const ZEND_ACC_EARLY_BINDING =           (1 << 16);

        /** call through user function trampoline. e.g.
         * __call, __callstatic     */
        const ZEND_ACC_CALL_VIA_TRAMPOLINE =     (1 << 18);

        /** disable inline caching   */
        const ZEND_ACC_NEVER_CACHE =             (1 << 19);

        /** Closure related          */
        const ZEND_ACC_CLOSURE =                 (1 << 20);
        const ZEND_ACC_FAKE_CLOSURE =            (1 << 21);

        /** run_time_cache allocated on heap (user only);       */
        const ZEND_ACC_HEAP_RT_CACHE =           (1 << 22);

        /** method flag used by Closure::__invoke();   */
        const ZEND_ACC_USER_ARG_INFO =           (1 << 23);

        const ZEND_ACC_GENERATOR =               (1 << 24);

        const ZEND_ACC_DONE_PASS_TWO =           (1 << 25);

        /** internal function is allocated at arena (int only); */
        const ZEND_ACC_ARENA_ALLOCATED =         (1 << 26);

        /** op_array is a clone of trait method        */
        const ZEND_ACC_TRAIT_CLONE =             (1 << 27);

        /** functions is a constructor      */
        const ZEND_ACC_CTOR =                    (1 << 28);

        /** function is a destructor */
        const ZEND_ACC_DTOR =                    (1 << 29);

        /** op_array uses strict mode types */
        const ZEND_ACC_STRICT_TYPES =            (1 << 31);

        const ZEND_ACC_PPP_MASK = self::ZEND_ACC_PUBLIC | self::ZEND_ACC_PROTECTED | self::ZEND_ACC_PRIVATE;

        /**
         * Type of zend_function.type
         */
        const ZEND_INTERNAL_FUNCTION    = 1;
        const ZEND_USER_FUNCTION        = 2;
        const ZEND_EVAL_CODE            = 4;

        const ZEND_INTERNAL_CLASS       = 1;
        const ZEND_USER_CLASS           = 2;

        /**
         * User opcode handler return values
         */
        /** execute next opcode */
        const ZEND_USER_OPCODE_CONTINUE    = 0;
        /** exit from executor (return from function) */
        const ZEND_USER_OPCODE_RETURN      = 1;
        /** call original opcode handler */
        const ZEND_USER_OPCODE_DISPATCH    = 2;
        /** enter into new op_array without recursion */
        const ZEND_USER_OPCODE_ENTER       = 3;
        /** return to calling op_array within the same executor */
        const ZEND_USER_OPCODE_LEAVE       = 4;
        /** call original handler of returned opcode */
        const ZEND_USER_OPCODE_DISPATCH_TO = 0x100;

        const SUCCESS     = 0;
        const FAILURE     = -1;

        const BOOL        = 'bool';
        const UNDEF       = self::IS_UNDEF;
        const NULL        = self::IS_NULL;
        const FALSE       = self::IS_FALSE;
        const TRUE        = self::IS_TRUE;

        /** Type of the zval. One of the `ZE::IS_*` constants. */
        const TYPE_P        = 'type';
        /** Integer value. */
        const LVAL_P        = 'lval';
        /** Floating-point value. */
        const DVAL_P        = 'dval';
        /** Pointer to full zend_string structure. */
        const STR_P         = 'str';
        /** String contents of the zend_string struct. */
        const STRVAL_P      = 'sval';
        /** String length of the zend_string struct. */
        const STRLEN_P      = 'slen';
        /** Pointer to HashTable structure. */
        const ARR_P         = 'arr';
        /** Alias of Z_ARR. */
        const ARRVAL_P      = 'aval';
        /** Pointer to zend_object structure. */
        const OBJ_P         = 'obj';
        /** Class entry of the object. */
        const OBJCE_P       = 'objce';
        /** Pointer to zend_resource structure. */
        const RES_P         = 'res';
        /** Pointer to zend_reference structure. */
        const REF_P         = 'ref';
        /** Void pointer. */
        const PTR_P         = 'ptr';
        /** Pointer to the zval the reference wraps. */
        const REFVAL_P      = 'rval';
        const TYPE_INFO_P   = 'info';
        /** Pointer a reference count, tracks how many places a structure is used */
        const COUNTED_P             = 'counted';
        const TYPE_INFO_REFCOUNTED  = 'refcounted';

        const IS_TYPE_REFCOUNTED      = (1 << 0);
        const IS_TYPE_COLLECTABLE     = (1 << 1);
        const Z_TYPE_FLAGS_SHIFT      = 8;

        /** array flags */
        const IS_ARRAY_IMMUTABLE      = self::GC_IMMUTABLE;
        const IS_ARRAY_PERSISTENT     = self::GC_PERSISTENT;

        /** object flags (zval.value->gc.u.flags) */
        const IS_OBJ_WEAKLY_REFERENCED  = self::GC_PERSISTENT;
        const IS_OBJ_DESTRUCTOR_CALLED  = (1 << 8);
        const IS_OBJ_FREE_CALLED        = (1 << 9);

        /** Regular data types: Must be in sync with zend_variables.c. */
        const IS_UNDEF          = 0;
        const IS_NULL           = 1;
        const IS_FALSE          = 2;
        const IS_TRUE           = 3;
        const IS_LONG           = 4;
        const IS_DOUBLE         = 5;
        const IS_STRING         = 6;
        const IS_ARRAY          = 7;
        const IS_OBJECT         = 8;
        const IS_RESOURCE       = 9;
        const IS_REFERENCE      = 10;
        /** Constant expressions */
        const IS_CONSTANT_AST   = 11;

        /** Fake types used only for type hinting. PHP74 (Z_TYPE(zv) can not use them)
         * These are allowed to overlap with the types below.
         * (Z_TYPE(zv) `PHP 74` can not use them) */
        const IS_CALLABLE       = \IS_PHP74 ? 17 : 12;
        const IS_ITERABLE       = \IS_PHP74 ? 18 : 13;
        const IS_VOID           = \IS_PHP74 ? 19 : 14;
        const IS_STATIC         = 15;
        const IS_MIXED          = 16;
        const IS_NEVER          = 17;

        /** internal types */
        const IS_INDIRECT       = \IS_PHP74 ? 13 : 12;
        const IS_PTR            = \IS_PHP74 ? 14 : 13;
        const IS_ALIAS_PTR      = \IS_PHP74 ? 15 : 14;
        const _IS_ERROR         = 15;

        /** string flags (zval.value->gc.u.flags) */
        /** interned string */
        const IS_STR_INTERNED     = self::GC_IMMUTABLE;
        /** allocated using malloc */
        const IS_STR_PERSISTENT   = self::GC_PERSISTENT;
        /** relives request boundary */
        const IS_STR_PERMANENT    = (1 << 8);
        /** valid UTF-8 according to PCRE */
        const IS_STR_VALID_UTF8   = (1 << 9);

        /** extended types */
        const IS_INTERNED_STRING_EX     = self::IS_STRING;
        const IS_REFERENCE_EX           = (self::IS_REFERENCE | (self::IS_TYPE_REFCOUNTED << self::Z_TYPE_FLAGS_SHIFT));
        const IS_RESOURCE_EX            = (self::IS_RESOURCE | (self::IS_TYPE_REFCOUNTED << self::Z_TYPE_FLAGS_SHIFT));
        const IS_STRING_EX              = (self::IS_STRING | (self::IS_TYPE_REFCOUNTED << self::Z_TYPE_FLAGS_SHIFT));
        const IS_ARRAY_EX               = (self::IS_ARRAY | (self::IS_TYPE_REFCOUNTED << self::Z_TYPE_FLAGS_SHIFT)
            | (self::IS_TYPE_COLLECTABLE << self::Z_TYPE_FLAGS_SHIFT));
        const IS_OBJECT_EX              = (self::IS_OBJECT | (self::IS_TYPE_REFCOUNTED << self::Z_TYPE_FLAGS_SHIFT)
            | (self::IS_TYPE_COLLECTABLE << self::Z_TYPE_FLAGS_SHIFT));

        protected ?CData $ze = null;
        protected ?CData $ze_ptr = null;

        protected ?CData $ze_other = null;
        protected ?CData $ze_other_ptr = null;

        protected $isZval = true;

        /**
         * Reversed class constants, containing names by number
         *
         * @var string[]
         */
        private static array $constant_names = [];

        use ZETrait;

        protected function __construct(string $typedef, bool $isZval = true)
        {
            $this->isZval = $isZval;
            if ($this->isZval) {
                //$this->ze_ptr = \ffi_ptr(\ze_ffi()->new($typedef, false));
                $this->ze = \ze_ffi()->new($typedef);
                $this->ze_ptr = \ffi_ptr($this->ze);
            } else {
                $this->ze_other = \ze_ffi()->new($typedef);
                $this->ze_other_ptr = \ffi_ptr($this->ze_other);
            }
        }

        public function __invoke($isZval = true)
        {
            if ($this->isZval && $isZval)
                return $this->ze_ptr;

            return $this->ze_other_ptr;
        }

        public function free(): void
        {
            if (!$this->isZval) {
                if (\is_cdata($this->ze_other_ptr) && !\is_null_ptr($this->ze_other_ptr))
                    \FFI::free($this->ze_other_ptr);

                $this->ze_other_ptr = null;
                $this->ze_other = null;
            } else {
                if (\is_cdata($this->ze_ptr) && !\is_null_ptr($this->ze_ptr))
                    \FFI::free($this->ze_ptr);

                $this->ze_ptr = null;
                $this->ze = null;
            }

            self::$constant_names = [];
        }

        public function update(CData $ptr, bool $isOther = false): self
        {
            if ($this->isZval && !$isOther) {
                $this->ze_ptr = $ptr;
            } else {
                $this->ze_other_ptr = $ptr;
            }

            return $this;
        }

        /**
         * Returns the type name of code
         *
         * @param int $valueCode Integer value of type
         */
        public static function name(int $valueCode): string
        {
            if (empty(self::$constant_names)) {
                static::$constant_names = \array_flip((new \ReflectionClass(static::class))->getConstants());
            }

            // We should use only low byte to get the name of constant
            $valueCode &= 0xFF;
            if (!isset(static::$constant_names[$valueCode])) {
                return \ze_ffi()->zend_error(\E_WARNING, 'Unknown code %d.', $valueCode);
            }

            return static::$constant_names[$valueCode];
        }
    }
}
