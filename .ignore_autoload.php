<?php

declare(strict_types=1);

if (!\defined('DS'))
  \define('DS', \DIRECTORY_SEPARATOR);

$directory = '.' . \DS;
if (\file_exists($directory . '.gitignore')) {
  $ignore = \file_get_contents($directory . '.gitignore');
  if (\strpos($ignore, '.cdef/') === false) {
    $ignore .= '.cdef/' . \PHP_EOL;
    \file_put_contents($directory . '.gitignore', $ignore);
  }
} else {
  \file_put_contents($directory . '.gitignore', '.cdef' . \DS . \PHP_EOL);
}

print "- Initialized .gitignore" . \PHP_EOL;

if (\file_exists($directory . '.gitattributes')) {
  $export = \file_get_contents($directory . '.gitattributes');
  if (\strpos($export, '/.cdef') === false) {
    $export .= '/.cdef       export-ignore' . \PHP_EOL;
    \file_put_contents($directory . '.gitattributes', $export);
  }
} else {
  \file_put_contents($directory . '.gitattributes', '/.cdef       export-ignore' . \PHP_EOL);
}

print "- Initialized .gitattributes" . \PHP_EOL;

$composerJson = [
  "name" => "/",
  "description" => "Some library as a FFI extension.",
  "keywords" => [],
  "homepage" => "https://github.com/",
  "license" => "",
  "authors" => [
    [
      "name" => "",
      "email" => ""
    ]
  ],
  "type" => "project",
  "require" => [
    "php" => ">7.4",
    "ext-ffi" => "*",
    "symplely/zend-ffi" => ">0.9.0"
  ],
  "autoload" => [
    "files" => [
      "preload.php"
    ],
    "psr-4" => [
      "" => "./"
    ]
  ],
  "autoload-dev" => [
    "psr-4" => [
      "" => "tests/"
    ]
  ],
  "scripts" => [
    "post-create-project-cmd" => [
      "php .ignore_autoload.php",
      "composer update -d ../..",
    ]
  ]
];

\unlink($directory . 'composer.json');
\file_put_contents(
  $directory . 'composer.json',
  \json_encode($composerJson, \JSON_PRETTY_PRINT | \JSON_UNESCAPED_SLASHES)
);

print "- Initialized `autoload` & `require` composer.json" . \PHP_EOL;

\unlink(__FILE__);
\rename('.ignore_autoload_skeleton.php', '.ignore_autoload.php');

\unlink('preload.php');
\rename('preload_skeleton.php', 'preload.php');

\unlink('ffi_extension.php');
\rename('ffi_extension_skeleton.php', 'ffi_extension.php');

\unlink('LICENSE');
\unlink('README.md');
\unlink('phpunit.xml.dist');
