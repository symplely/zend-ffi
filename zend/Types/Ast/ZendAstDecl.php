<?php

declare(strict_types=1);

namespace ZE\Ast;

use ZE\ZendString;
use ZE\Ast\ZendAst;
use ZE\Ast\ZendAstKind;

/**
 * `ZendAstDecl` is used for class and function declarations
 *
 *```cpp
 * typedef struct _zend_ast_decl {
 *   zend_ast_kind kind;
 *   zend_ast_attr attr; // Unused - for structure compatibility
 *   uint32_t start_lineno;
 *   uint32_t end_lineno;
 *   uint32_t flags;
 *   unsigned char *lex_pos;
 *   zend_string *doc_comment;
 *   zend_string *name;
 *   zend_ast *child[4];
 * } zend_ast_decl;
 *```
 */
class ZendAstDecl extends ZendAst
{
    /**
     * Creates a declaration of given type
     */
    public function __construct(
        int $kind,
        int $flags,
        int $startLine,
        int $endLine,
        string $docComment,
        string $name,
        ?ZendAst ...$childrenNodes
    ) {
        if (!ZendAstKind::is_special($kind)) {
            $kindName = ZendAstKind::name($kind);
            throw new \InvalidArgumentException('Given AST type ' . $kindName . ' does not belong to declaration');
        }

        if (\count($childrenNodes) > 4) {
            throw new \InvalidArgumentException('Declaration node can contain only up to 4 children nodes');
        }

        // Fill exactly 4 nodes with default null values
        $childrenNodes = $childrenNodes + \array_fill(0, 4, null);

        // ZEND_API zend_ast *zend_ast_create_decl(
        //    zend_ast_kind kind, uint32_t flags, uint32_t start_lineno, zend_string *doc_comment,
        //    zend_string *name, zend_ast *child0, zend_ast *child1, zend_ast *child2, zend_ast *child3
        //);
        $ast = \ze_ffi()->zend_ast_create_decl(
            $kind,
            $flags,
            $startLine,
            $endLine,
            $docComment,
            $name,
            ...$childrenNodes
        );

        $declaration = \ze_ffi()->cast('zend_ast_decl *', $ast);

        $this->ze_other_ptr = $declaration;
    }

    /**
     * Return start line
     *
     * @param integer|null $newLine Changes the start line
     * @return integer|void
     */
    public function start_lineno(int $newLine = null): int
    {
        if (\is_null($newLine))
            return $this->ze_other_ptr->start_lineno;

        $this->ze_other_ptr->start_lineno = $newLine;
    }

    /**
     * Returns the end line
     *
     * @param integer|null $newLine Changes the end line
     * @return integer|void
     */
    public function end_lineno(int $newLine = null)
    {
        if (\is_null($newLine))
            return $this->ze_other_ptr->end_lineno;

        $this->ze_other_ptr->end_lineno = $newLine;
    }

    /**
     * Returns flags
     *
     * @param integer|null $newLine Changes flags
     * @return integer|void
     */
    public function flags(int $newFlags = null)
    {
        if (\is_null($newFlags))
            return $this->ze_other_ptr->flags;

        $this->ze_other_ptr->flags = $newFlags;
    }

    public function lex_pos(): int
    {
        return $this->ze_other_ptr->lex_pos[0];
    }

    /**
     * Returns doc comment
     *
     * @param string|null $newDocComment Changes the doc comment for this declaration
     * @return string|void
     */
    public function doc_comment(string $newDocComment = null): string
    {
        if (\is_null($newDocComment)) {
            if ($this->ze_other_ptr->doc_comment === null) {
                return '';
            }

            // TODO: investigate what to do with string copying
            return ZendString::init_value($this->ze_other_ptr->doc_comment)->copy()->value();
        }

        $entry = ZendString::init($newDocComment);

        // TODO: investigate what to do with string copying
        $this->ze_other_ptr->doc_comment = $entry->copy()->value();
    }


    /**
     * Returns the name of entry
     */
    public function get_name(): string
    {
        // TODO: investigate what to do with string copying
        return ZendString::init_value($this->ze_other_ptr->name)->copy()->value();
    }

    /**
     * Changes the name of this node
     */
    public function set_name(string $newName): void
    {
        $entry = ZendString::init($newName);

        // TODO: investigate what to do with string copying
        $this->ze_other_ptr->name = $entry->copy()();
    }

    /**
     * @inheritDoc
     */
    public function num_children(): int
    {
        // Declaration node always contain 4 children nodes.
        return 4;
    }

    /**
     * @inheritDoc
     */
    protected function dumpThis(int $indent = 0): string
    {
        $line = parent::dumpThis($indent);

        $kind = $this->getKind();

        if ($kind !== ZendAstKind::AST_CLOSURE) {
            $line .= ' ' . $this->get_name();
        }

        $flags = $this->flags();
        if ($flags !== 0) {
            $line .= \sprintf(" flags(%04x)", $flags);
        }

        return $line;
    }
}
