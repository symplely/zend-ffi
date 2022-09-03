<?php

declare(strict_types=1);

namespace ZE;

use FFI\CData;
use ZE\ZendExecutor;

if (!\class_exists('Opcode')) {
    class OpCode extends \ZE
    {
        protected $isZval = false;

        const NOP                        = 0;
        const ADD                        = 1;
        const SUB                        = 2;
        const MUL                        = 3;
        const DIV                        = 4;
        const MOD                        = 5;
        const SL                         = 6;
        const SR                         = 7;
        const CONCAT                     = 8;
        const BW_OR                      = 9;
        const BW_AND                     = 10;
        const BW_XOR                     = 11;
        const POW                        = 12;
        const BW_NOT                     = 13;
        const BOOL_NOT                   = 14;
        const BOOL_XOR                   = 15;
        const IS_IDENTICAL               = 16;
        const IS_NOT_IDENTICAL           = 17;
        const IS_EQUAL                   = 18;
        const IS_NOT_EQUAL               = 19;
        const IS_SMALLER                 = 20;
        const IS_SMALLER_OR_EQUAL        = 21;
        const ASSIGN                     = 22;
        const ASSIGN_DIM                 = 23;
        const ASSIGN_OBJ                 = 24;
        const ASSIGN_STATIC_PROP         = 25;
        const ASSIGN_OP                  = 26;
        const ASSIGN_DIM_OP              = 27;
        const ASSIGN_OBJ_OP              = 28;
        const ASSIGN_STATIC_PROP_OP      = 29;
        const ASSIGN_REF                 = 30;
        const QM_ASSIGN                  = 31;
        const ASSIGN_OBJ_REF             = 32;
        const ASSIGN_STATIC_PROP_REF     = 33;
        const PRE_INC                    = 34;
        const PRE_DEC                    = 35;
        const POST_INC                   = 36;
        const POST_DEC                   = 37;
        const PRE_INC_STATIC_PROP        = 38;
        const PRE_DEC_STATIC_PROP        = 39;
        const POST_INC_STATIC_PROP       = 40;
        const POST_DEC_STATIC_PROP       = 41;
        const JMP                        = 42;
        const JMPZ                       = 43;
        const JMPNZ                      = 44;
        const JMPZNZ                     = 45;
        const JMPZ_EX                    = 46;
        const JMPNZ_EX                   = 47;
        const CASE                       = 48;
        const CHECK_VAR                  = 49;
        const SEND_VAR_NO_REF_EX         = 50;
        const CAST                       = 51;
        const BOOL                       = 52;
        const FAST_CONCAT                = 53;
        const ROPE_INIT                  = 54;
        const ROPE_ADD                   = 55;
        const ROPE_END                   = 56;
        const BEGIN_SILENCE              = 57;
        const END_SILENCE                = 58;
        const INIT_FCALL_BY_NAME         = 59;
        const DO_FCALL                   = 60;
        const INIT_FCALL                 = 61;
        const RETURN                     = 62;
        const RECV                       = 63;
        const RECV_INIT                  = 64;
        const SEND_VAL                   = 65;
        const SEND_VAR_EX                = 66;
        const SEND_REF                   = 67;
        const NEW                        = 68;
        const INIT_NS_FCALL_BY_NAME      = 69;
        const FREE                       = 70;
        const INIT_ARRAY                 = 71;
        const ADD_ARRAY_ELEMENT          = 72;
        const INCLUDE_OR_EVAL            = 73;
        const UNSET_VAR                  = 74;
        const UNSET_DIM                  = 75;
        const UNSET_OBJ                  = 76;
        const FE_RESET_R                 = 77;
        const FE_FETCH_R                 = 78;
        const EXIT                       = 79;
        const FETCH_R                    = 80;
        const FETCH_DIM_R                = 81;
        const FETCH_OBJ_R                = 82;
        const FETCH_W                    = 83;
        const FETCH_DIM_W                = 84;
        const FETCH_OBJ_W                = 85;
        const FETCH_RW                   = 86;
        const FETCH_DIM_RW               = 87;
        const FETCH_OBJ_RW               = 88;
        const FETCH_IS                   = 89;
        const FETCH_DIM_IS               = 90;
        const FETCH_OBJ_IS               = 91;
        const FETCH_FUNC_ARG             = 92;
        const FETCH_DIM_FUNC_ARG         = 93;
        const FETCH_OBJ_FUNC_ARG         = 94;
        const FETCH_UNSET                = 95;
        const FETCH_DIM_UNSET            = 96;
        const FETCH_OBJ_UNSET            = 97;
        const FETCH_LIST_R               = 98;
        const FETCH_CONSTANT             = 99;
        const CHECK_FUNC_ARG             = 100;
        const EXT_STMT                   = 101;
        const EXT_FCALL_BEGIN            = 102;
        const EXT_FCALL_END              = 103;
        const EXT_NOP                    = 104;
        const TICKS                      = 105;
        const SEND_VAR_NO_REF            = 106;
        const CATCH                      = 107;
        const THROW                      = 108;
        const FETCH_CLASS                = 109;
        const CLONE                      = 110;
        const RETURN_BY_REF              = 111;
        const INIT_METHOD_CALL           = 112;
        const INIT_STATIC_METHOD_CALL    = 113;
        const ISSET_ISEMPTY_VAR          = 114;
        const ISSET_ISEMPTY_DIM_OBJ      = 115;
        const SEND_VAL_EX                = 116;
        const SEND_VAR                   = 117;
        const INIT_USER_CALL             = 118;
        const SEND_ARRAY                 = 119;
        const SEND_USER                  = 120;
        const STRLEN                     = 121;
        const DEFINED                    = 122;
        const TYPE_CHECK                 = 123;
        const VERIFY_RETURN_TYPE         = 124;
        const FE_RESET_RW                = 125;
        const FE_FETCH_RW                = 126;
        const FE_FREE                    = 127;
        const INIT_DYNAMIC_CALL          = 128;
        const DO_ICALL                   = 129;
        const DO_UCALL                   = 130;
        const DO_FCALL_BY_NAME           = 131;
        const PRE_INC_OBJ                = 132;
        const PRE_DEC_OBJ                = 133;
        const POST_INC_OBJ               = 134;
        const POST_DEC_OBJ               = 135;
        const ECHO                       = 136;
        const OP_DATA                    = 137;
        const INSTANCEOF                 = 138;
        const GENERATOR_CREATE           = 139;
        const MAKE_REF                   = 140;
        const DECLARE_FUNCTION           = 141;
        const DECLARE_LAMBDA_FUNCTION    = 142;
        const DECLARE_CONST              = 143;
        const DECLARE_CLASS              = 144;
        const DECLARE_CLASS_DELAYED      = 145;
        const DECLARE_ANON_CLASS         = 146;
        const ADD_ARRAY_UNPACK           = 147;
        const ISSET_ISEMPTY_PROP_OBJ     = 148;
        const HANDLE_EXCEPTION           = 149;
        const USER_OPCODE                = 150;
        const ASSERT_CHECK               = 151;
        const JMP_SET                    = 152;
        const UNSET_CV                   = 153;
        const ISSET_ISEMPTY_CV           = 154;
        const FETCH_LIST_W               = 155;
        const SEPARATE                   = 156;
        const FETCH_CLASS_NAME           = 157;
        const CALL_TRAMPOLINE            = 158;
        const DISCARD_EXCEPTION          = 159;
        const YIELD                      = 160;
        const GENERATOR_RETURN           = 161;
        const FAST_CALL                  = 162;
        const FAST_RET                   = 163;
        const RECV_VARIADIC              = 164;
        const SEND_UNPACK                = 165;
        const YIELD_FROM                 = 166;
        const COPY_TMP                   = 167;
        const BIND_GLOBAL                = 168;
        const COALESCE                   = 169;
        const SPACESHIP                  = 170;
        const FUNC_NUM_ARGS              = 171;
        const FUNC_GET_ARGS              = 172;
        const FETCH_STATIC_PROP_R        = 173;
        const FETCH_STATIC_PROP_W        = 174;
        const FETCH_STATIC_PROP_RW       = 175;
        const FETCH_STATIC_PROP_IS       = 176;
        const FETCH_STATIC_PROP_FUNC_ARG = 177;
        const FETCH_STATIC_PROP_UNSET    = 178;
        const UNSET_STATIC_PROP          = 179;
        const ISSET_ISEMPTY_STATIC_PROP  = 180;
        const FETCH_CLASS_CONSTANT       = 181;
        const BIND_LEXICAL               = 182;
        const BIND_STATIC                = 183;
        const FETCH_THIS                 = 184;
        const SEND_FUNC_ARG              = 185;
        const ISSET_ISEMPTY_THIS         = 186;
        const SWITCH_LONG                = 187;
        const SWITCH_STRING              = 188;
        const IN_ARRAY                   = 189;
        const COUNT                      = 190;
        const GET_CLASS                  = 191;
        const GET_CALLED_CLASS           = 192;
        const GET_TYPE                   = 193;
        const ARRAY_KEY_EXIST            = 194;
        const MATCH                      = 195;
        const CASE_STRICT                = 196;
        const MATCH_ERROR                = 197;
        const JMP_NULL                   = 198;
        const CHECK_UNDEF_ARGS           = 199;

        /**
         * Reversed class constants, containing names by number
         *
         * @var string[]
         */
        private static array $opCodeNames = [];

        /**
         * Returns the type name of opcode
         *
         * @param int $opCode Integer value of opType
         */
        public static function name(int $opCode): string
        {
            if (empty(self::$opCodeNames)) {
                self::$opCodeNames = \array_flip((new \ReflectionClass(self::class))->getConstants());
            }

            $opCode &= 0xFF;
            if (!isset(self::$opCodeNames[$opCode])) {
                return \ze_ffi()->zend_error(\E_WARNING, 'Unknown code %d. New version of PHP?', $opCode);
            }

            return self::$opCodeNames[$opCode];
        }

        /**
         * Installs a user opcode handler that will be used to handle specific opcode
         *
         * @param int|\zend_uchar $opCode  Operation code to hook
         * @param \Closure $handler Callback that will receive a control for overloaded operation code
         */
        public static function set_handler(int $opCode, \Closure $handler): void
        {
            self::validate_opcode_handler($handler);
            $result = \ze_ffi()->zend_set_user_opcode_handler($opCode, function (CData $state) use ($handler) {
                $trace = \debug_backtrace(\DEBUG_BACKTRACE_IGNORE_ARGS, 2);
                $class = $trace[1]['class'] ?? '';
                if (\strpos($class, 'ZE') === 0) {
                    // For all our internal classes just proceed with default opcode handler

                    return \ZE::ZEND_USER_OPCODE_DISPATCH;
                }
                $executionState = ZendExecutor::init_value($state);
                $handleResult   = $handler($executionState);

                return $handleResult;
            });

            if ($result === \ZE::FAILURE) {
                \ze_ffi()->zend_error(\E_WARNING, 'Can not install user opcode handler');
                return;
            }
        }

        /**
         * Restores default opcode handler
         *
         * @param int|\zend_uchar $opCode Operation code
         */
        public static function restore_handler(int $opCode): void
        {
            $result = \ze_ffi()->zend_set_user_opcode_handler($opCode, null);
            if ($result === \ZE::FAILURE) {
                \ze_ffi()->zend_error(\E_WARNING, 'Can not restore original opcode handler');
                return;
            }
        }

        /**
         * Validate that given callback can be used as opcode handler, otherwise stop execution with an error.
         *
         * @param \Closure $handler User-defined opcode handler
         */
        private static function validate_opcode_handler(\Closure $handler): void
        {
            $reflection = new \ReflectionFunction($handler);

            $hasOneArgument = $reflection->getNumberOfParameters() === 1;
            $hasValidReturnType = $reflection->hasReturnType() && ($reflection->getReturnType()->getName() === 'int');
            if (!$hasValidReturnType || !$hasOneArgument) {
                \ze_ffi()->zend_error(\E_ERROR, 'Opcode handler signature should be: function($scope): int {}');
                return;
            }
        }
    }
}
