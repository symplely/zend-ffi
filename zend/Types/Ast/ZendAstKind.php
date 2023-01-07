<?php

declare(strict_types=1);

namespace ZE\Ast;

use FFI\CData;
use ZE\Zval;

if (!\class_exists('ZendAstKind')) {
    /**
     * Declares possible AST nodes kind
     */
    final class ZendAstKind
    {
        const AST_SPECIAL_SHIFT      = 6;
        const AST_IS_LIST_SHIFT      = 7;
        const AST_NUM_CHILDREN_SHIFT = 8;

        const KIND_ADDER    = \IS_PHP74 ? 0 : 1;

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
        const AST_TYPE_UNION        = \IS_PHP74 ? -1 : self::AST_ARG_LIST + 16;
        const AST_TYPE_INTERSECTION = \IS_PHP74 ? -1 : self::AST_ARG_LIST + 17;
        const AST_ATTRIBUTE_LIST    = \IS_PHP74 ? -1 : self::AST_ARG_LIST + 18;
        const AST_ATTRIBUTE_GROUP   = \IS_PHP74 ? -1 : self::AST_ARG_LIST + 19;
        const AST_MATCH_ARM_LIST    = \IS_PHP74 ? -1 : self::AST_ARG_LIST + 20;

        /* 0 child nodes */
        const AST_MAGIC_CONST       = 0 << self::AST_NUM_CHILDREN_SHIFT;
        const AST_TYPE              = self::AST_MAGIC_CONST + 1;
        const AST_CONSTANT_CLASS    = self::AST_MAGIC_CONST + 2;
        const AST_CALLABLE_CONVERT  = \IS_PHP74 ? -1 : self::AST_MAGIC_CONST + 3;

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
        const AST_NULLSAFE_PROP   = \IS_PHP74 ? -1 : self::AST_DIM + 2;
        const AST_STATIC_PROP     = self::AST_DIM + 2 + self::KIND_ADDER;
        const AST_CALL            = self::AST_DIM + 3 + self::KIND_ADDER;
        const AST_CLASS_CONST     = self::AST_DIM + 4 + self::KIND_ADDER;
        const AST_ASSIGN          = self::AST_DIM + 5 + self::KIND_ADDER;
        const AST_ASSIGN_REF      = self::AST_DIM + 6 + self::KIND_ADDER;
        const AST_ASSIGN_OP       = self::AST_DIM + 7 + self::KIND_ADDER;
        const AST_BINARY_OP       = self::AST_DIM + 8 + self::KIND_ADDER;
        const AST_GREATER         = self::AST_DIM + 9 + self::KIND_ADDER;
        const AST_GREATER_EQUAL   = self::AST_DIM + 10 + self::KIND_ADDER;
        const AST_AND             = self::AST_DIM + 11 + self::KIND_ADDER;
        const AST_OR              = self::AST_DIM + 12 + self::KIND_ADDER;
        const AST_ARRAY_ELEM      = self::AST_DIM + 13 + self::KIND_ADDER;
        const AST_NEW             = self::AST_DIM + 14 + self::KIND_ADDER;
        const AST_INSTANCEOF      = self::AST_DIM + 15 + self::KIND_ADDER;
        const AST_YIELD           = self::AST_DIM + 16 + self::KIND_ADDER;
        const AST_COALESCE        = self::AST_DIM + 17 + self::KIND_ADDER;
        const AST_ASSIGN_COALESCE = self::AST_DIM + 18 + self::KIND_ADDER;

        const AST_STATIC           = self::AST_DIM + 19 + self::KIND_ADDER;
        const AST_WHILE            = self::AST_DIM + 20 + self::KIND_ADDER;
        const AST_DO_WHILE         = self::AST_DIM + 21 + self::KIND_ADDER;
        const AST_IF_ELEM          = self::AST_DIM + 22 + self::KIND_ADDER;
        const AST_SWITCH           = self::AST_DIM + 23 + self::KIND_ADDER;
        const AST_SWITCH_CASE      = self::AST_DIM + 24 + self::KIND_ADDER;
        const AST_DECLARE          = self::AST_DIM + 25 + self::KIND_ADDER;
        const AST_USE_TRAIT        = self::AST_DIM + 26 + self::KIND_ADDER;
        const AST_TRAIT_PRECEDENCE = self::AST_DIM + 27 + self::KIND_ADDER;
        const AST_METHOD_REFERENCE = self::AST_DIM + 28 + self::KIND_ADDER;
        const AST_NAMESPACE        = self::AST_DIM + 29 + self::KIND_ADDER;
        const AST_USE_ELEM         = self::AST_DIM + 30 + self::KIND_ADDER;
        const AST_TRAIT_ALIAS      = self::AST_DIM + 31 + self::KIND_ADDER;
        const AST_GROUP_USE        = self::AST_DIM + 32 + self::KIND_ADDER;

        const AST_CLASS_CONST_GROUP = \IS_PHP74 ? -1 : self::AST_DIM + 33;
        const AST_ATTRIBUTE         = \IS_PHP74 ? -1 : self::AST_DIM + 34;
        const AST_MATCH             = \IS_PHP74 ? -1 : self::AST_DIM + 35;
        const AST_MATCH_ARM         = \IS_PHP74 ? -1 : self::AST_DIM + 36;
        const AST_NAMED_ARG         = \IS_PHP74 ? -1 : self::AST_DIM + 37;

        /* 3 child nodes */
        const AST_METHOD_CALL           = 3 << self::AST_NUM_CHILDREN_SHIFT;
        const AST_NULLSAFE_METHOD_CALL  = \IS_PHP74 ? -1 : self::AST_METHOD_CALL + 1;
        const AST_STATIC_CALL           = self::AST_METHOD_CALL + 1 + self::KIND_ADDER;
        const AST_CONDITIONAL           = self::AST_METHOD_CALL + 2 + self::KIND_ADDER;

        const AST_TRY           = self::AST_METHOD_CALL + 3 + self::KIND_ADDER;
        const AST_CATCH         = self::AST_METHOD_CALL + 4 + self::KIND_ADDER;
        const AST_PROP_GROUP    = \IS_PHP74 ? self::AST_DIM + 33 : self::AST_METHOD_CALL + 6;
        const AST_PROP_ELEM     = self::AST_METHOD_CALL + 6 + self::KIND_ADDER;
        const AST_CONST_ELEM    = self::AST_METHOD_CALL + 7 + self::KIND_ADDER;

        // Pseudo node for initializing enums
        const AST_CONST_ENUM_INIT = \IS_PHP74 ? -1 : self::AST_METHOD_CALL + 9;

        /* 4 child nodes */
        const AST_FOR       = 4 << self::AST_NUM_CHILDREN_SHIFT;
        const AST_FOREACH   = self::AST_FOR + 1;
        const AST_ENUM_CASE = self::AST_FOR + 2;

        /* 5 child nodes */
        const AST_PARAM      = \IS_PHP74
            ? self::AST_METHOD_CALL + 5 : 5 << self::AST_NUM_CHILDREN_SHIFT;

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

        public static function ast_is_list(CData $ast): bool
        {
            return self::is_list($ast->kind);
        }

        public static function ast_get_list(CData $ast): CData
        {
            if (self::ast_is_list($ast))
                return \ze_ffi()->cast('zend_ast_list *', $ast);
        }

        public static function ast_get_lineno(CData $ast): int
        {
            if ($ast->kind == self::AST_ZVAL) {
                return self::ast_get_zval($ast)->extra();
            } else {
                return $ast->lineno;
            }
        }

        public static function ast_get_zval(CData $ast): Zval
        {
            return Zval::init_value(\ze_ffi()->cast('zend_ast_zval *', $ast)->val);
        }

        public static function ast_get_num_children(CData $ast): int
        {
            return self::num_children($ast->kind);
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

        public static function parse(CData $ast, CData $nast): void
        {
            if ($ast->kind == self::AST_ZVAL) {
                $nast->kind = \ffi_char(self::to_string($ast->kind));
                $nast->lineno = self::ast_get_lineno($ast);

                $zv = self::ast_get_zval($ast);
                if ($zv instanceof Zval) {
                    switch ($zv->macro(\ZE::TYPE_P)) {
                        case \ZE::IS_LONG:
                            $nast->value = \sprintf("%d", (int)$zv->macro(\ZE::TYPE_P));
                            break;
                        case \ZE::IS_DOUBLE:
                            $nast->value = \sprintf("%.2f", $zv->macro(\ZE::DVAL_P));
                            break;
                        case \ZE::IS_STRING:
                            $nast->value = $zv->macro(\ZE::STRVAL_P);
                            break;
                        default:
                            $nast->value = "UNKNOWN"; //@todo
                    }
                }

                return;
            }

            if (self::is_decl($ast->kind)) {
                $decl = \ze_ffi()->cast('zend_ast_decl *', $ast);

                $nast->kind = \ffi_char(self::to_string($ast->kind));
                $nast->lineno = self::ast_get_lineno($ast);
                $nast->value = $decl->name->val;
                self::parse_decl($decl, $nast);
                return;
            }

            if (self::ast_is_list($ast)) {
                $nast->kind = \ffi_char(self::to_string($ast->kind));
                $nast->lineno = self::ast_get_lineno($ast);
                self::parse_list($ast, $nast);
                return;
            }

            $nast->kind = \ffi_char(self::to_string($ast->kind));
            $nast->lineno = self::ast_get_lineno($ast);
            self::parse_as_list($ast, $nast);
        }

        public static function parse_list(CData $ast, CData $nast): void
        {
            $ast_list = self::ast_get_list($ast);
            $nast->children = 0;
            for ($i = 0; $i < $ast_list->children; $i++) {
                if (!\is_null($ast_list->child[$i])) {
                    $nast->child[$nast->children] = Node::create_ast();
                    self::parse($ast_list->child[$i], $nast->child[$nast->children]);
                    $nast->children++;
                } else {
                    \ze_ffi()->zend_error(\E_WARNING, "list %s [%d] not found\n", $nast->kind, $i);
                }
            }
        }

        public static function parse_as_list(CData $ast, CData $nast): void
        {
            $nast->children = 0;
            for ($i = 0; $i < self::ast_get_num_children($ast); $i++) {
                if ($ast->child[$i]) {
                    $nast->child[$nast->children] = Node::create_ast();
                    self::parse($ast->child[$i], $nast->child[$nast->children]);
                    $nast->children++;
                } else {
                    \ze_ffi()->zend_error(\E_WARNING, "as_list %s [%d] not found\n", $nast->kind, $i);
                }
            }
        }

        public static function parse_decl(CData $ast, CData $nast)
        {
            $nast->children = 0;
            for ($i = 0; $i < 5; $i++) {
                if ($ast->child[$i]) {
                    $nast->child[$nast->children] = Node::create_ast();
                    self::parse($ast->child[$i], $nast->child[$nast->children]);
                    $nast->children++;
                } else {
                    \ze_ffi()->zend_error(\E_WARNING, "decl %s [%d] not found\n", $nast->kind, $i);
                }
            }
        }

        public static function is_decl(int $kind): bool
        {
            return $kind == self::AST_FUNC_DECL
                || $kind == self::AST_CLOSURE
                || $kind == self::AST_ARROW_FUNC
                || $kind == self::AST_METHOD
                || $kind == self::AST_CLASS;
        }

        public static function to_string(int $kind): string
        {
            switch ($kind) {
                case self::AST_ZVAL:
                    return "ZEND_AST_ZVAL";
                    break;
                case self::AST_CONSTANT:
                    return "ZEND_AST_CONSTANT";
                    break;
                case self::AST_ZNODE:
                    return "ZEND_AST_ZNODE";
                    break;
                case self::AST_FUNC_DECL:
                    return "ZEND_AST_FUNC_DECL";
                    break;
                case self::AST_CLOSURE:
                    return "ZEND_AST_CLOSURE";
                    break;
                case self::AST_METHOD:
                    return "ZEND_AST_METHOD";
                    break;
                case self::AST_CLASS:
                    return "ZEND_AST_CLASS";
                    break;
                case self::AST_ARROW_FUNC:
                    return "ZEND_AST_ARROW_FUNC";
                    break;
                case self::AST_ARG_LIST:
                    return "ZEND_AST_ARG_LIST";
                    break;
                case self::AST_ARRAY:
                    return "ZEND_AST_ARRAY";
                    break;
                case self::AST_ENCAPS_LIST:
                    return "ZEND_AST_ENCAPS_LIST";
                    break;
                case self::AST_EXPR_LIST:
                    return "ZEND_AST_EXPR_LIST";
                    break;
                case self::AST_STMT_LIST:
                    return "ZEND_AST_STMT_LIST";
                    break;
                case self::AST_IF:
                    return "ZEND_AST_IF";
                    break;
                case self::AST_SWITCH_LIST:
                    return "ZEND_AST_SWITCH_LIST";
                    break;
                case self::AST_CATCH_LIST:
                    return "ZEND_AST_CATCH_LIST";
                    break;
                case self::AST_PARAM_LIST:
                    return "ZEND_AST_PARAM_LIST";
                    break;
                case self::AST_CLOSURE_USES:
                    return "ZEND_AST_CLOSURE_USES";
                    break;
                case self::AST_PROP_DECL:
                    return "ZEND_AST_PROP_DECL";
                    break;
                case self::AST_CONST_DECL:
                    return "ZEND_AST_CONST_DECL";
                    break;
                case self::AST_CLASS_CONST_DECL:
                    return "ZEND_AST_CLASS_CONST_DECL";
                    break;
                case self::AST_NAME_LIST:
                    return "ZEND_AST_NAME_LIST";
                    break;
                case self::AST_TRAIT_ADAPTATIONS:
                    return "ZEND_AST_TRAIT_ADAPTATIONS";
                    break;
                case self::AST_USE:
                    return "ZEND_AST_USE";
                    break;
                case self::AST_TYPE_UNION:
                    return "ZEND_AST_TYPE_UNION";
                    break;
                case self::AST_TYPE_INTERSECTION:
                    return "ZEND_AST_TYPE_INTERSECTION";
                    break;
                case self::AST_ATTRIBUTE_LIST:
                    return "ZEND_AST_ATTRIBUTE_LIST";
                    break;
                case self::AST_ATTRIBUTE_GROUP:
                    return "ZEND_AST_ATTRIBUTE_GROUP";
                    break;
                case self::AST_MATCH_ARM_LIST:
                    return "ZEND_AST_MATCH_ARM_LIST";
                    break;
                case self::AST_MAGIC_CONST:
                    return "ZEND_AST_MAGIC_CONST";
                    break;
                case self::AST_TYPE:
                    return "ZEND_AST_TYPE";
                    break;
                case self::AST_CONSTANT_CLASS:
                    return "ZEND_AST_CONSTANT_CLASS";
                    break;
                case self::AST_CALLABLE_CONVERT:
                    return "ZEND_AST_CALLABLE_CONVERT";
                    break;
                case self::AST_VAR:
                    return "ZEND_AST_VAR";
                    break;
                case self::AST_CONST:
                    return "ZEND_AST_CONST";
                    break;
                case self::AST_UNPACK:
                    return "ZEND_AST_UNPACK";
                    break;
                case self::AST_UNARY_PLUS:
                    return "ZEND_AST_UNARY_PLUS";
                    break;
                case self::AST_UNARY_MINUS:
                    return "ZEND_AST_UNARY_MINUS";
                    break;
                case self::AST_CAST:
                    return "ZEND_AST_CAST";
                    break;
                case self::AST_EMPTY:
                    return "ZEND_AST_EMPTY";
                    break;
                case self::AST_ISSET:
                    return "ZEND_AST_ISSET";
                    break;
                case self::AST_SILENCE:
                    return "ZEND_AST_SILENCE";
                    break;
                case self::AST_SHELL_EXEC:
                    return "ZEND_AST_SHELL_EXEC";
                    break;
                case self::AST_CLONE:
                    return "ZEND_AST_CLONE";
                    break;
                case self::AST_EXIT:
                    return "ZEND_AST_EXIT";
                    break;
                case self::AST_PRINT:
                    return "ZEND_AST_PRINT";
                    break;
                case self::AST_INCLUDE_OR_EVAL:
                    return "ZEND_AST_INCLUDE_OR_EVAL";
                    break;
                case self::AST_UNARY_OP:
                    return "ZEND_AST_UNARY_OP";
                    break;
                case self::AST_PRE_INC:
                    return "ZEND_AST_PRE_INC";
                    break;
                case self::AST_PRE_DEC:
                    return "ZEND_AST_PRE_DEC";
                    break;
                case self::AST_POST_INC:
                    return "ZEND_AST_POST_INC";
                    break;
                case self::AST_POST_DEC:
                    return "ZEND_AST_POST_DEC";
                    break;
                case self::AST_YIELD_FROM:
                    return "ZEND_AST_YIELD_FROM";
                    break;
                case self::AST_CLASS_NAME:
                    return "ZEND_AST_CLASS_NAME";
                    break;
                case self::AST_GLOBAL:
                    return "ZEND_AST_GLOBAL";
                    break;
                case self::AST_UNSET:
                    return "ZEND_AST_UNSET";
                    break;
                case self::AST_RETURN:
                    return "ZEND_AST_RETURN";
                    break;
                case self::AST_LABEL:
                    return "ZEND_AST_LABEL";
                    break;
                case self::AST_REF:
                    return "ZEND_AST_REF";
                    break;
                case self::AST_HALT_COMPILER:
                    return "ZEND_AST_HALT_COMPILER";
                    break;
                case self::AST_ECHO:
                    return "ZEND_AST_ECHO";
                    break;
                case self::AST_THROW:
                    return "ZEND_AST_THROW";
                    break;
                case self::AST_GOTO:
                    return "ZEND_AST_GOTO";
                    break;
                case self::AST_BREAK:
                    return "ZEND_AST_BREAK";
                    break;
                case self::AST_CONTINUE:
                    return "ZEND_AST_CONTINUE";
                    break;
                case self::AST_DIM:
                    return "ZEND_AST_DIM";
                    break;
                case self::AST_PROP:
                    return "ZEND_AST_PROP";
                    break;
                case self::AST_NULLSAFE_PROP:
                    return "ZEND_AST_NULLSAFE_PROP";
                    break;
                case self::AST_STATIC_PROP:
                    return "ZEND_AST_STATIC_PROP";
                    break;
                case self::AST_CALL:
                    return "ZEND_AST_CALL";
                    break;
                case self::AST_CLASS_CONST:
                    return "ZEND_AST_CLASS_CONST";
                    break;
                case self::AST_ASSIGN:
                    return "ZEND_AST_ASSIGN";
                    break;
                case self::AST_ASSIGN_REF:
                    return "ZEND_AST_ASSIGN_REF";
                    break;
                case self::AST_ASSIGN_OP:
                    return "ZEND_AST_ASSIGN_OP";
                    break;
                case self::AST_BINARY_OP:
                    return "ZEND_AST_BINARY_OP";
                    break;
                case self::AST_GREATER:
                    return "ZEND_AST_GREATER";
                    break;
                case self::AST_GREATER_EQUAL:
                    return "ZEND_AST_GREATER_EQUAL";
                    break;
                case self::AST_AND:
                    return "ZEND_AST_AND";
                    break;
                case self::AST_OR:
                    return "ZEND_AST_OR";
                    break;
                case self::AST_ARRAY_ELEM:
                    return "ZEND_AST_ARRAY_ELEM";
                    break;
                case self::AST_NEW:
                    return "ZEND_AST_NEW";
                    break;
                case self::AST_INSTANCEOF:
                    return "ZEND_AST_INSTANCEOF";
                    break;
                case self::AST_YIELD:
                    return "ZEND_AST_YIELD";
                    break;
                case self::AST_COALESCE:
                    return "ZEND_AST_COALESCE";
                    break;
                case self::AST_ASSIGN_COALESCE:
                    return "ZEND_AST_ASSIGN_COALESCE";
                    break;
                case self::AST_STATIC:
                    return "ZEND_AST_STATIC";
                    break;
                case self::AST_WHILE:
                    return "ZEND_AST_WHILE";
                    break;
                case self::AST_DO_WHILE:
                    return "ZEND_AST_DO_WHILE";
                    break;
                case self::AST_IF_ELEM:
                    return "ZEND_AST_IF_ELEM";
                    break;
                case self::AST_SWITCH:
                    return "ZEND_AST_SWITCH";
                    break;
                case self::AST_SWITCH_CASE:
                    return "ZEND_AST_SWITCH_CASE";
                    break;
                case self::AST_DECLARE:
                    return "ZEND_AST_DECLARE";
                    break;
                case self::AST_USE_TRAIT:
                    return "ZEND_AST_USE_TRAIT";
                    break;
                case self::AST_TRAIT_PRECEDENCE:
                    return "ZEND_AST_TRAIT_PRECEDENCE";
                    break;
                case self::AST_METHOD_REFERENCE:
                    return "ZEND_AST_METHOD_REFERENCE";
                    break;
                case self::AST_NAMESPACE:
                    return "ZEND_AST_NAMESPACE";
                    break;
                case self::AST_USE_ELEM:
                    return "ZEND_AST_USE_ELEM";
                    break;
                case self::AST_TRAIT_ALIAS:
                    return "ZEND_AST_TRAIT_ALIAS";
                    break;
                case self::AST_GROUP_USE:
                    return "ZEND_AST_GROUP_USE";
                    break;
                case self::AST_CLASS_CONST_GROUP:
                    return "ZEND_AST_CLASS_CONST_GROUP";
                    break;
                case self::AST_ATTRIBUTE:
                    return "ZEND_AST_ATTRIBUTE";
                    break;
                case self::AST_MATCH:
                    return "ZEND_AST_MATCH";
                    break;
                case self::AST_MATCH_ARM:
                    return "ZEND_AST_MATCH_ARM";
                    break;
                case self::AST_NAMED_ARG:
                    return "ZEND_AST_NAMED_ARG";
                    break;
                case self::AST_METHOD_CALL:
                    return "ZEND_AST_METHOD_CALL";
                    break;
                case self::AST_NULLSAFE_METHOD_CALL:
                    return "ZEND_AST_NULLSAFE_METHOD_CALL";
                    break;
                case self::AST_STATIC_CALL:
                    return "ZEND_AST_STATIC_CALL";
                    break;
                case self::AST_CONDITIONAL:
                    return "ZEND_AST_CONDITIONAL";
                    break;
                case self::AST_TRY:
                    return "ZEND_AST_TRY";
                    break;
                case self::AST_CATCH:
                    return "ZEND_AST_CATCH";
                    break;
                case self::AST_PROP_GROUP:
                    return "ZEND_AST_PROP_GROUP";
                    break;
                case self::AST_PROP_ELEM:
                    return "ZEND_AST_PROP_ELEM";
                    break;
                case self::AST_CONST_ELEM:
                    return "ZEND_AST_CONST_ELEM";
                    break;
                case self::AST_CONST_ENUM_INIT:
                    return "ZEND_AST_CONST_ENUM_INIT";
                    break;
                case self::AST_FOR:
                    return "ZEND_AST_FOR";
                    break;
                case self::AST_FOREACH:
                    return "ZEND_AST_FOREACH";
                    break;
                case self::AST_ENUM_CASE:
                    return "ZEND_AST_ENUM_CASE";
                    break;
                case self::AST_PARAM:
                    return "ZEND_AST_PARAM";
                    break;
                default: {
                        return \sprintf("UNKNOWN: %d", $kind);
                    }
            }
        }
    }
}
