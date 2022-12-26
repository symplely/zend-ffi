<?php

declare(strict_types=1);

namespace ZE;

use ZE\Zval;
use ZE\ZendAst;

/**
 * `ZendAstZval` stores a zval
 *
 * // Lineno is stored in val.u2.lineno
 * typedef struct _zend_ast_zval {
 *   zend_ast_kind kind;
 *   zend_ast_attr attr;
 *   zval val;
 * } zend_ast_zval;
 *
 * @see zend_ast.h:zend_ast_zval
 */
class ZendAstZval extends ZendAst
{
    /**
     * Creates an AST node from value
     *
     * @param mixed $value Any valid value
     * @param int $attributes Additional attributes
     */
    public function __construct($value, int $attributes = 0)
    {
        // This code is used to extract a Zval for our $value argument and use its internal pointer
        $valueArgument = ZendExecutor::init()->call_argument(0);
        $rawValue = $valueArgument();

        $node = \ze_ffi()->zend_ast_create_zval_ex($rawValue, $attributes);
        $node = \ze_ffi()->cast('zend_ast_zval *', $node);

        $this->ze_other_ptr = $node;
    }

    /**
     * Returns current value
     */
    public function value(): Zval
    {
        return Zval::init_value($this->ze_other_ptr->val);
    }

    /**
     * For ValueNode line is stored in the val.u2.lineno
     *
     * @inheritDoc
     */
    public function lineno(int $newLine = null): int
    {
        return $this->value()->extra();
    }

    /**
     * @inheritDoc
     * Value node doesn't have children nodes
     */
    public function num_children(): int
    {
        return 0;
    }

    /**
     * @inheritDoc
     */
    public function dumpThis(int $indent = 0): string
    {
        $line = parent::dumpThis($indent);

        $line .= ' ';
        $this->value()->native_value($value);
        if (\is_scalar($value)) {
            $line .= \gettype($value) . '(' . \var_export($value, true) . ')';
        } else {
            // shouldn't happen
            $line .= \gettype($value) . "\n";
        }

        return $line;
    }
}
