<?php

declare(strict_types=1);

namespace ZE\Ast;

use ZE\Ast\ZendAst;
use ZE\Ast\ZendAstKind;

if (!\class_exists('ZendAstList')) {
    /**
     * `ZendAstList` is used where the number of children is determined dynamically.
     *
     * It is identical to ordinary AST nodes, but contains an additional children count.
     *
     *```cpp
     * typedef struct _zend_ast_list {
     *   zend_ast_kind kind;
     *   zend_ast_attr attr;
     *   zend_uint lineno;
     *   zend_uint children;
     *   zend_ast *child[1];
     * } zend_ast_list;
     *```
     */
    final class ZendAstList extends ZendAst
    {
        /**
         * Creates a list of given type
         *
         * @param int $kind
         */
        public function __construct(int $kind)
        {
            if (!ZendAstKind::is_list($kind)) {
                $kindName = ZendAstKind::name($kind);
                throw new \InvalidArgumentException('Given AST type ' . $kindName . ' does not belong to list type');
            }

            $ast  = \ze_ffi()->zend_ast_create_list_0($kind);
            $list = \ze_ffi()->cast('zend_ast_list *', $ast);

            $this->ze_other_ptr = $list;
        }

        /**
         * Returns children node count
         */
        public function num_children(): int
        {
            // List stores the number of nodes in separate field
            return $this->ze_other_ptr->children;
        }

        /**
         * Adds one or several nodes to the list
         *
         * @param ZendAst|mixed ...$nodes List of nodes to add
         */
        public function append(ZendAst ...$nodes): void
        {
            // This variable can be re-declared (if list will grow during node addition)
            $selfNode = \ze_ffi()->cast('zend_ast *', $this->ze_other_ptr);
            foreach ($nodes as $node) {
                $astNode  = \ze_ffi()->cast('zend_ast *', $node());
                $selfNode = \ze_ffi()->zend_ast_list_add($selfNode, $astNode);
            }

            $this->ze_other_ptr = \ze_ffi()->cast('zend_ast_list *', $selfNode);
        }
    }
}
