<?php

declare(strict_types=1);

if (!\defined('DS'))
  \define('DS', \DIRECTORY_SEPARATOR);

function recursiveDelete($directory, $options = [])
{
  if (!isset($options['traverseSymlinks']))
    $options['traverseSymlinks'] = false;
  $files = \array_diff(\scandir($directory), ['.', '..']);
  foreach ($files as $file) {
    $dirFile = $directory . \DS . $file;
    if (\is_dir($dirFile)) {
      if (!$options['traverseSymlinks'] && \is_link(\rtrim($file, \DS))) {
        \unlink($dirFile);
      } else {
        \recursiveDelete($dirFile, $options);
      }
    } else {
      \unlink($dirFile);
    }
  }

  return \rmdir($directory);
}

$directory = '.' . \DS;
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

\rename('.gitattributes.skeleton', '.gitattributes');
\rename('.gitignore.skeleton', '.gitignore');
\rename('.ci', '.github');

\unlink('LICENSE');

\recursiveDelete('headers');
\recursiveDelete('zend');

\mkdir('headers');
\mkdir('lib');
\mkdir('src');
\mkdir('tests');
