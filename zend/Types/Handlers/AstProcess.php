<?php

declare(strict_types=1);

namespace ZE\Hook;

use FFI\CData;
use ZE\ZendAst;
use ZE\ObjectHandler;

/**
 * Receiving hook for processing an AST
 */
class AstProcess extends ObjectHandler
{
    protected const HOOK_FIELD = 'zend_ast_process';

    /**
     * Instance of top-level AST node
     */
    protected CData $ast;

    /**
     * typedef `void` (*zend_ast_process_t)(zend_ast *ast);
     *
     * @inheritDoc
     */
    public function handle(...$c_args): void
    {
        [$this->ast] = $c_args;

        ($this->userHandler)($this);
    }

    /**
     * Returns a top-level node element
     */
    public function get_ast(): ZendAst
    {
        return ZendAst::factory($this->ast);
    }

    /**
     * Proceeds with default callback
     */
    public function continue()
    {
        if (!$this->has_original()) {
            throw new \LogicException('Original handler is not available');
        }

        ($this->originalHandler)($this->ast);
    }
}
