<?php

declare(strict_types=1);

namespace ZE;

use FFI\CData;

/**
 * General `ZendAst` class that can contain several children nodes
 *
 *```cpp
 * typedef struct _zend_ast {
 *   zend_ast_kind kind;
 *   zend_ast_attr attr;
 *   zend_uint lineno;
 *   struct _zend_ast *child[1];
 * } zend_ast;
 *```
 */
class ZendAst extends \ZE
{
    protected $isZval = false;

    /**
     * This `factory` is used to create an PHP instance of concrete CData `zend_ast` entry.
     */
    public static function factory(CData $node): ZendAst
    {
        $kind = $node->kind;
        switch (true) {
                // There are special node types ZVAL, CONSTANT, ZNODE
            case $kind === ZendAstKind::AST_ZVAL:
                $node = \ze_ffi()->cast('zend_ast_zval *', $node);
                return ZendAstZval::init_value($node);
            case $kind === ZendAstKind::AST_CONSTANT:
            case $kind === ZendAstKind::AST_ZNODE:
                throw new \RuntimeException('Not yet supported: ' . ZendAstKind::name($kind));
            case ZendAstKind::is_special($kind):
                $node = \ze_ffi()->cast('zend_ast_decl *', $node);
                return ZendAstDecl::init_value($node);
            case ZendAstKind::is_list($kind):
                $node = \ze_ffi()->cast('zend_ast_list *', $node);
                return ZendAstList::init_value($node);
            default:
                return ZendAst::init_value($node);
        }
    }

    /**
     * Creates an instance of ZendAst
     *
     * @param int $kind Node kind
     * @param int $attributes Node attributes (like modifier, options, etc)
     * @param ZendAst|null ...$nodes List of nested ZendAst (if required)
     */
    public static function init(int $kind, int $attributes, ?ZendAst ...$nodes): ZendAst
    {
        $nodeCount = \count($nodes);
        $expectedCount = ZendAstKind::num_children($kind);
        if ($expectedCount !== $nodeCount || $nodeCount > 4) {
            $kindName = ZendAstKind::name($kind);
            $message = 'Given AST type ' . $kindName . ' expects exactly ' . $expectedCount . ' argument(s).';
            throw new \InvalidArgumentException($message);
        }

        $funcName = "zend_ast_create_{$nodeCount}";
        $arguments = [];
        foreach ($nodes as $index => $node) {
            if ($node === null) {
                $arguments[$index] = null;
            } else {
                $arguments[$index] = \ze_ffi()->cast('zend_ast *', $node->node);
            }
        }

        $node = (\ze_ffi()->{$funcName})($kind, ...$arguments);
        $ast = static::init_value($node);
        $ast->attr($attributes);

        return $ast;
    }

    /**
     * Returns the constant indicating the type of the AST node
     *
     * @see NodeKind class constants
     */
    final public function kind(): int
    {
        return $this->ze_other_ptr->kind;
    }

    /**
     * Returns node's kind-specific flags
     *
     * @param integer $newAttributes Changes node attributes
     * @return integer|void
     */
    final public function attr(int $newAttributes = null): int
    {
        if (\is_null($newAttributes))
            return $this->ze_other_ptr->attr;

        $this->ze_other_ptr->attr = $newAttributes;
    }

    /**
     * Returns the start line number of the node
     *
     * @param integer|null $newLine Changes the node line
     * @return integer|void
     */
    public function lineno(int $newLine = null): int
    {
        if (\is_null($newLine))
            return $this->ze_other_ptr->lineno;

        $this->ze_other_ptr->lineno = $newLine;
    }

    /**
     * Returns the number of children for this node
     */
    public function num_children(): int
    {
        return ZendAstKind::num_children($this->ze_other_ptr->kind);
    }

    /**
     * Returns children of this node
     *
     * @return ZendAst[]
     */
    final public function children(): array
    {
        $totalChildren = $this->num_children();
        if ($totalChildren === 0) {
            return [];
        }

        $children     = [];
        $castChildren = \ze_ffi()->cast('zend_ast **', $this->ze_other_ptr->child);
        for ($index = 0; $index < $totalChildren; $index++) {
            if ($castChildren[$index] !== null) {
                $children[$index] = self::factory($castChildren[$index]);
            } else {
                $children[$index] = null;
            }
        }

        return $children;
    }

    /**
     * Return concrete child by index (can be empty)
     *
     * @param int $index Index of child node
     */
    final public function child(int $index): ?ZendAst
    {
        $totalChildren = $this->num_children();
        if ($index >= $totalChildren) {
            throw new \OutOfBoundsException('Child index is out of range, there are ' . $totalChildren . ' children.');
        }

        $castChildren = \ze_ffi()->cast('zend_ast **', $this->ze_other_ptr->child);
        if ($castChildren[$index] === null) {
            return null;
        }

        return self::factory($castChildren[$index]);
    }

    /**
     * Replace one child node with another one without checks
     *
     * @param int $index Child node index
     * @param ZendAst $node New node to use
     */
    public function replace(int $index, ZendAst $node): void
    {
        $totalChildren = $this->num_children();
        if ($index >= $totalChildren) {
            throw new \OutOfBoundsException('Child index is out of range, there are ' . $totalChildren . ' children.');
        }

        $castChildren = \ze_ffi()->cast('zend_ast **', $this->ze_other_ptr->child);
        $castChildren[$index] = \ze_ffi()->cast('zend_ast *', $node->node);
    }

    /**
     * Removes a child node from the tree and returns the removed node.
     *
     * @param int $index Index of the node to remove
     */
    public function remove(int $index): ZendAst
    {
        $totalChildren = $this->getChildrenCount();
        if ($index >= $totalChildren) {
            throw new \OutOfBoundsException('Child index is out of range, there are ' . $totalChildren . ' children.');
        }

        $castChildren = \ze_ffi()->cast('zend_ast **', $this->ze_other_ptr->child);
        $child = self::factory($castChildren[$index]);

        $castChildren[$index] = null;

        return $child;
    }

    /**
     * This method is used to prevent segmentation faults when dumping CData
     */
    final public function __debugInfo(): array
    {
        $result  = [];
        $methods = (new \ReflectionClass(static::class))->getMethods(\ReflectionMethod::IS_PUBLIC);
        foreach ($methods as $method) {
            $methodName = $method->getName();
            if ((\strpos($methodName, 'get') === 0) && $method->getNumberOfRequiredParameters() === 0) {
                $name = \lcfirst(\substr($methodName, 3));
                $result[$name] = $this->$methodName();
            }
        }

        return $result;
    }

    /**
     * Dumps current node in friendly format
     *
     * @param int $indent Level of indentation
     */
    final public function dump(int $indent = 0): string
    {
        $content = \sprintf('%4d', $this->getLine()) . ': ';
        $content .= $this->dumpThis($indent) . "\n";

        $childrenCount = $this->num_children();
        if ($childrenCount > 0) {
            $children = $this->children();
            $content .= $this->dumpChildren($indent, ...$children);
        }

        return $content;
    }

    /**
     * Dumps current node itself (without children)
     */
    protected function dumpThis(int $indent = 0): string
    {
        $line = \str_repeat(' ', 2 * $indent);
        $line .= ZendAstKind::name($this->kind());

        $attributes = $this->getAttributes();
        if ($attributes !== 0) {
            $line .= \sprintf(" attrs(%04x)", $attributes);
        }

        return $line;
    }

    /**
     * Helper method to dump children nodes
     *
     * @param int $indent Current level of indentation
     * @param ZendAst|null ...$nodes List of children nodes (can contain null values)
     */
    private function dumpChildren(int $indent = 0, ?ZendAst ...$nodes): string
    {
        $content = '';
        foreach ($nodes as $index => $node) {
            if ($node === null) {
                continue;
            }
            $content .= $node->dump($indent + 1);
        }

        return $content;
    }
}
