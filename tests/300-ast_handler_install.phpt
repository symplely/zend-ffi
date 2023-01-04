--TEST--
Check for ast handler install
--SKIPIF--
<?php if (!extension_loaded("ffi")) print "skip"; ?>
--FILE--
<?php
require 'vendor/autoload.php';

zend_ast_process(function (\ZE\AstProcess $hook) {
    $ast = $hook->get_ast();
    echo "Parsed AST:", PHP_EOL, $ast->dump();
    // Let's modify Yes to No )
    echo $ast->child()->child()->child()->get_value()->change_value('No');
});

eval('echo "Yes";');
--EXPECTF--
Parsed AST:
   1: AST_STMT_LIST
   1:   AST_STMT_LIST
   1:     AST_ECHO
   1:       AST_ZVAL string('Yes')
No
