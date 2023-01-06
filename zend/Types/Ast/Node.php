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

    private function __construct()
    {
    }

    public static function parse(string $content): Node
    {
        $ast = \zend_parse_string($content);

        return self::create($ast());
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

    private static function create(CData $ast): Node
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
