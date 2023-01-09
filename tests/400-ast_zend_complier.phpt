--TEST--
Check for Ast Zend Complier
--SKIPIF--
<?php if (!extension_loaded("ffi")) print "skip"; ?>
--FILE--
<?php
require 'vendor/autoload.php';

$nodes = zend_parse_string('echo "Hello World". PHP_EOL;');

print_ast($nodes);

--EXPECTF--
   1: AST_STMT_LIST
   1:   AST_STMT_LIST
   1:     AST_ECHO
   1:       AST_BINARY_OP attrs(0008)
   1:         AST_ZVAL string('Hello World')
   1:         AST_CONST
   1:           AST_ZVAL attrs(0001) string('PHP_EOL')
