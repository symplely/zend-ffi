<?php

declare(strict_types=1);

if (!\defined('DS'))
    \define('DS', \DIRECTORY_SEPARATOR);

$directory = '..' . \DS . '..' . \DS;
$ffi_list = \json_decode(\file_get_contents('.' . \DS . 'ffi_extension.json'), true);
$ext = $ffi_list['name'];
if (\file_exists($directory . '.gitignore')) {
    $ignore = \file_get_contents($directory . '.gitignore');
    if (\strpos($ignore, '.cdef/') === false) {
        $ignore .= '.cdef/' . \PHP_EOL;
        \file_put_contents($directory . '.gitignore', $ignore);
    }
} else {
    \file_put_contents($directory . '.gitignore', '.cdef' . \DS . \PHP_EOL);
}

print "- Initialized .gitignore" . PHP_EOL;

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

$composerJson = [];
$package = '';
if (\file_exists($directory . 'composer.json')) {
    $composerJson = \json_decode(\file_get_contents($directory . 'composer.json'), true);
    $package = $composerJson['name'];
}

if (isset($composerJson['autoload'])) {
    if (isset($composerJson['autoload']['files']) && !\in_array(".cdef/ffi_preloader.php", $composerJson['autoload']['files']))
        \array_push($composerJson['autoload']['files'], ".cdef/ffi_preloader.php");
    elseif (!isset($composerJson['autoload']['files']))
        $composerJson = \array_merge($composerJson, ["autoload" => ["files" => [".cdef/ffi_preloader.php"]]]);
    /*
  if (isset($composerJson['autoload']['classmap']) && !\in_array(".cdef/$ext/", $composerJson['autoload']['classmap']))
    \array_push($composerJson['autoload']['classmap'], ".cdef/$ext/");
  elseif (!isset($composerJson['autoload']['classmap']))
    $composerJson = \array_merge($composerJson, ["autoload" => ["classmap" => [".cdef/$ext/"]]]);

  if (isset($composerJson['autoload']['psr-4']) && !\in_array(".cdef/$ext/", $composerJson['autoload']['psr-4']))
    \array_push($composerJson["autoload"]["psr-4"], ["" => ".cdef/$ext/"]);
  elseif (!isset($composerJson['autoload']['psr-4']))
    $composerJson = \array_merge($composerJson, ["autoload" => ["psr-4" => ["" => ".cdef/$ext/"]]]);
  */
} else {
    $composerJson = [
        "name" => "/",
        "description" => "C Language library as a extension for FFI usage.",
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
            "ext-ffi" => "*"
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
}

if (isset($composerJson['require'][$package]))
    unset($composerJson['require'][$package]);

if (!isset($composerJson['require']['symplely/zend-ffi']))
    \array_push($composerJson['require'], ["symplely/zend-ffi" => ">0.9.0"]);

\file_put_contents(
    $directory . 'composer.json',
    \json_encode($composerJson, \JSON_PRETTY_PRINT | \JSON_UNESCAPED_SLASHES)
);

print "- Initialized `autoload` & `require` composer.json" . \PHP_EOL;

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

/**
 * Any additional custom code should be added below.
 */

$isWindows = '\\' === \DS;
$delete = '';
if (!$isWindows) {
    $delete .= 'Windows ';
}

if (\PHP_OS !== 'Darwin') {
    $delete .= 'Apple macOS ';
}

if (\php_uname('m') !== 'aarch64') {
    $delete .= 'Raspberry Pi ';
}

if ($isWindows)
    $version = 0;
else {
    $os = [];
    $files = \glob('/etc/*-release');
    foreach ($files as $file) {
        $lines = \array_filter(\array_map(function ($line) {
            // split value from key
            $parts = \explode('=', $line);
            // makes sure that "useless" lines are ignored (together with array_filter)
            if (\count($parts) !== 2)
                return false;

            // remove quotes, if the value is quoted
            $parts[1] = \str_replace(['"', "'"], '', $parts[1]);
            return $parts;
        }, \file($file)));

        foreach ($lines as $line)
            $os[$line[0]] = $line[1];
    }

    $id = \trim((string) $os['ID']);
    $like = \trim((string) $os['ID_LIKE']);
    $version = \trim((string) $os['VERSION_ID']);
}

if ((float)$version !== 20.04 || $isWindows) {
    $delete .= 'Ubuntu 20.04 ';
}

if ((float)$version !== 18.04 || $isWindows) {
    $delete .= 'Ubuntu 18.04 ';
}

if (!(float)$version >= 8 || $isWindows) {
    $delete .= 'Centos 8+ ';
}

if (!(float)$version < 8 || $isWindows) {
    $delete .= 'Centos 7 ';
}

print "- Removed unneeded " . $delete . \PHP_EOL;

/**
 * Do not remove anything below.
 */

// Cleanup/remove vendor directory, if previously installed as a regular composer package.
$package = \str_replace('/', \DS, $package);
if (\file_exists($directory . 'vendor' . \DS . $package . \DS . 'composer.json'))
    \recursiveDelete($directory . 'vendor' . \DS . $package);

if (!\file_exists('..' . \DS . 'ffi_preloader.php'))
    \rename('ffi_preloader.php', '..' . \DS . 'ffi_preloader.php');
else
    \unlink('ffi_preloader.php');

if (!\file_exists('..' . \DS . 'ffi_generated.json')) {
    $directories = \glob('../*', \GLOB_ONLYDIR);
    $directory = $files = [];
    foreach ($directories as $ffi_dir) {
        if (\file_exists($ffi_dir . \DS . 'ffi_extension.json')) {
            $ffi_list = \json_decode(\file_get_contents($ffi_dir . \DS . 'ffi_extension.json'), true);
            if (isset($ffi_list['preload']['directory'])) {
                \array_push($directory, $ffi_list['preload']['directory']);
            } elseif (isset($ffi_list['preload']['files'])) {
                \array_push($files, $ffi_list['preload']['files']);
            }
        }
    }

    $preload_list = [
        "preload" => [
            "files" => $files,
            "directory" => $directory
        ]
    ];
} else {
    $preload_list = \json_decode(\file_get_contents('..' . \DS . 'ffi_generated.json'), true);
    $ext_list = \json_decode(\file_get_contents('.' . \DS . 'ffi_extension.json'), true);
    if (isset($ext_list['preload']['directory'])) {
        \array_push($preload_list['preload']['directory'], $ext_list['preload']['directory']);
    } elseif (isset($ext_list['preload']['files'])) {
        \array_push($preload_list['preload']['files'], $ext_list['preload']['files']);
    }
}

\file_put_contents(
    '..' . \DS . 'ffi_generated.json',
    \json_encode($preload_list, \JSON_PRETTY_PRINT | \JSON_UNESCAPED_SLASHES)
);
\chmod($directory . '.cdef' . \DS . $ext, 0644);

\unlink(__FILE__);

print "- `.cdef/ffi_generated.json` has been updated!" . \PHP_EOL;
