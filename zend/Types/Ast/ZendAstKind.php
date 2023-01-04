<?php

declare(strict_types=1);

namespace ZE\Ast;

if (!\class_exists('ZendAstKind')) {
    /**
     * Declares possible AST nodes kind
     */
    final class ZendAstKind
    {
        private const AST_SPECIAL_SHIFT      = 6;
        private const AST_IS_LIST_SHIFT      = 7;
        private const AST_NUM_CHILDREN_SHIFT = 8;

        const AST_ZVAL     = 1 << self::AST_SPECIAL_SHIFT;
        const AST_CONSTANT = self::AST_ZVAL + 1;
        const AST_ZNODE    = self::AST_ZVAL + 2;

        /* declaration nodes */
        const AST_FUNC_DECL  = self::AST_ZVAL + 3;
        const AST_CLOSURE    = self::AST_ZVAL + 4;
        const AST_METHOD     = self::AST_ZVAL + 5;
        const AST_CLASS      = self::AST_ZVAL + 6;
        const AST_ARROW_FUNC = self::AST_ZVAL + 7;

        /* list nodes */
        const AST_ARG_LIST          = 1 << self::AST_IS_LIST_SHIFT;
        const AST_ARRAY             = self::AST_ARG_LIST + 1;
        const AST_ENCAPS_LIST       = self::AST_ARG_LIST + 2;
        const AST_EXPR_LIST         = self::AST_ARG_LIST + 3;
        const AST_STMT_LIST         = self::AST_ARG_LIST + 4;
        const AST_IF                = self::AST_ARG_LIST + 5;
        const AST_SWITCH_LIST       = self::AST_ARG_LIST + 6;
        const AST_CATCH_LIST        = self::AST_ARG_LIST + 7;
        const AST_PARAM_LIST        = self::AST_ARG_LIST + 8;
        const AST_CLOSURE_USES      = self::AST_ARG_LIST + 9;
        const AST_PROP_DECL         = self::AST_ARG_LIST + 10;
        const AST_CONST_DECL        = self::AST_ARG_LIST + 11;
        const AST_CLASS_CONST_DECL  = self::AST_ARG_LIST + 12;
        const AST_NAME_LIST         = self::AST_ARG_LIST + 13;
        const AST_TRAIT_ADAPTATIONS = self::AST_ARG_LIST + 14;
        const AST_USE               = self::AST_ARG_LIST + 15;

        /* 0 child nodes */
        const AST_MAGIC_CONST    = 0 << self::AST_NUM_CHILDREN_SHIFT;
        const AST_TYPE           = self::AST_MAGIC_CONST + 1;
        const AST_CONSTANT_CLASS = self::AST_MAGIC_CONST + 2;

        /* 1 child node */
        const AST_VAR             = 1 << self::AST_NUM_CHILDREN_SHIFT;
        const AST_CONST           = self::AST_VAR + 1;
        const AST_UNPACK          = self::AST_VAR + 2;
        const AST_UNARY_PLUS      = self::AST_VAR + 3;
        const AST_UNARY_MINUS     = self::AST_VAR + 4;
        const AST_CAST            = self::AST_VAR + 5;
        const AST_EMPTY           = self::AST_VAR + 6;
        const AST_ISSET           = self::AST_VAR + 7;
        const AST_SILENCE         = self::AST_VAR + 8;
        const AST_SHELL_EXEC      = self::AST_VAR + 9;
        const AST_CLONE           = self::AST_VAR + 10;
        const AST_EXIT            = self::AST_VAR + 11;
        const AST_PRINT           = self::AST_VAR + 12;
        const AST_INCLUDE_OR_EVAL = self::AST_VAR + 13;
        const AST_UNARY_OP        = self::AST_VAR + 14;
        const AST_PRE_INC         = self::AST_VAR + 15;
        const AST_PRE_DEC         = self::AST_VAR + 16;
        const AST_POST_INC        = self::AST_VAR + 17;
        const AST_POST_DEC        = self::AST_VAR + 18;
        const AST_YIELD_FROM      = self::AST_VAR + 19;
        const AST_CLASS_NAME      = self::AST_VAR + 20;

        const AST_GLOBAL        = self::AST_VAR + 21;
        const AST_UNSET         = self::AST_VAR + 22;
        const AST_RETURN        = self::AST_VAR + 23;
        const AST_LABEL         = self::AST_VAR + 24;
        const AST_REF           = self::AST_VAR + 25;
        const AST_HALT_COMPILER = self::AST_VAR + 26;
        const AST_ECHO          = self::AST_VAR + 27;
        const AST_THROW         = self::AST_VAR + 28;
        const AST_GOTO          = self::AST_VAR + 29;
        const AST_BREAK         = self::AST_VAR + 30;
        const AST_CONTINUE      = self::AST_VAR + 31;

        /* 2 child nodes */
        const AST_DIM             = 2 << self::AST_NUM_CHILDREN_SHIFT;
        const AST_PROP            = self::AST_DIM + 1;
        const AST_STATIC_PROP     = self::AST_DIM + 2;
        const AST_CALL            = self::AST_DIM + 3;
        const AST_CLASS_CONST     = self::AST_DIM + 4;
        const AST_ASSIGN          = self::AST_DIM + 5;
        const AST_ASSIGN_REF      = self::AST_DIM + 6;
        const AST_ASSIGN_OP       = self::AST_DIM + 7;
        const AST_BINARY_OP       = self::AST_DIM + 8;
        const AST_GREATER         = self::AST_DIM + 9;
        const AST_GREATER_EQUAL   = self::AST_DIM + 10;
        const AST_AND             = self::AST_DIM + 11;
        const AST_OR              = self::AST_DIM + 12;
        const AST_ARRAY_ELEM      = self::AST_DIM + 13;
        const AST_NEW             = self::AST_DIM + 14;
        const AST_INSTANCEOF      = self::AST_DIM + 15;
        const AST_YIELD           = self::AST_DIM + 16;
        const AST_COALESCE        = self::AST_DIM + 17;
        const AST_ASSIGN_COALESCE = self::AST_DIM + 18;

        const AST_STATIC           = self::AST_DIM + 19;
        const AST_WHILE            = self::AST_DIM + 20;
        const AST_DO_WHILE         = self::AST_DIM + 21;
        const AST_IF_ELEM          = self::AST_DIM + 22;
        const AST_SWITCH           = self::AST_DIM + 23;
        const AST_SWITCH_CASE      = self::AST_DIM + 24;
        const AST_DECLARE          = self::AST_DIM + 25;
        const AST_USE_TRAIT        = self::AST_DIM + 26;
        const AST_TRAIT_PRECEDENCE = self::AST_DIM + 27;
        const AST_METHOD_REFERENCE = self::AST_DIM + 28;
        const AST_NAMESPACE        = self::AST_DIM + 29;
        const AST_USE_ELEM         = self::AST_DIM + 30;
        const AST_TRAIT_ALIAS      = self::AST_DIM + 31;
        const AST_GROUP_USE        = self::AST_DIM + 32;
        const AST_PROP_GROUP       = self::AST_DIM + 33;

        /* 3 child nodes */
        const AST_METHOD_CALL = 3 << self::AST_NUM_CHILDREN_SHIFT;
        const AST_STATIC_CALL = self::AST_METHOD_CALL + 1;
        const AST_CONDITIONAL = self::AST_METHOD_CALL + 2;

        const AST_TRY        = self::AST_METHOD_CALL + 3;
        const AST_CATCH      = self::AST_METHOD_CALL + 4;
        const AST_PARAM      = self::AST_METHOD_CALL + 5;
        const AST_PROP_ELEM  = self::AST_METHOD_CALL + 6;
        const AST_CONST_ELEM = self::AST_METHOD_CALL + 7;

        /* 4 child nodes */
        const AST_FOR = 4 << self::AST_NUM_CHILDREN_SHIFT;
        const AST_FOREACH = self::AST_FOR + 1;

        /**
         * Cache of constant names (reversed)
         *
         * @var string[]
         */
        private static array $constantNames = [];

        /**
         * Checks if the given AST node kind is special
         *
         * @param int $astKind Kind of node
         *
         * @see zend_ast.h:zend_ast_is_special
         */
        public static function is_special(int $astKind): bool
        {
            return (bool)(($astKind >> self::AST_SPECIAL_SHIFT) & 1);
        }

        /**
         * Checks if the given AST node kind is list
         *
         * @param int $astKind Kind of node
         *
         * @see zend_ast.h:zend_ast_is_list
         */
        public static function is_list(int $astKind): bool
        {
            return (bool)(($astKind >> self::AST_IS_LIST_SHIFT) & 1);
        }

        /**
         * Returns the number of children for that node
         *
         * @param int $astKind Kind of node
         */
        public static function num_children(int $astKind): int
        {
            return $astKind >> self::AST_NUM_CHILDREN_SHIFT;
        }

        /**
         * Returns the AST kind name
         *
         * @param int $astKind Integer value of AST node kind
         */
        public static function name(int $astKind): string
        {
            if (empty(self::$constantNames)) {
                self::$constantNames = \array_flip((new \ReflectionClass(self::class))->getConstants());
            }

            if (!isset(self::$constantNames[$astKind])) {
                throw new \UnexpectedValueException('Unknown code ' . $astKind . '. New version of PHP?');
            }

            return self::$constantNames[$astKind];
        }
    }
}
