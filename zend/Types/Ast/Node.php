<?php

declare(strict_types=1);

namespace ZE\Ast;

use FFI\CData;

final class Node
{
    public string $kind = "";
    public string $value = "";
    public int $lineno = 0;

    /** @var Node[] */
    public array $children = [];

    /** @var \CStruct[] */
    private static ?array $node_ast = [];

    public function __destruct()
    {
        self::$node_ast = null;
    }

    private function __construct()
    {
    }

    public static function create_ast(): CData
    {
        $node_ast = \c_typedef('node_ast', 'ze', false);
        $node_ast()->kind = \ffi_char("UNINITIALIZED");
        $node_ast()->value = \ffi_char("");
        $node_ast()->lineno = 0;
        $node_ast()->children = 0;

        self::$node_ast[] = $node_ast;

        return $node_ast();
    }

    public function dump(Node $node, int $indent = 0): void
    {
        self::print($node, $indent);
    }

    public static function print(Node $node, int $indent = 0): void
    {
        \printf(
            "[%03d] %s%s%s\n",
            $node->lineno,
            (\str_repeat(' ', $indent)),
            $node->kind,
            $node->value ? \sprintf(" \"%s\"", $node->value) : ''
        );

        foreach ($node->children as $child) {
            self::print($child, $indent + 2);
        }
    }

    public static function create(CData $ast): Node
    {
        $ast = $ast[0];

        $node = new self();
        $node->kind = $ast->kind;
        $node->value = $ast->value;
        $node->lineno = $ast->lineno;

        if ($ast->children > 0) {
            for ($i = 0; $i < $ast->children; $i++) {
                $node->children[] = self::create($ast->child[$i]);
            }
        }

        return $node;
    }
}
