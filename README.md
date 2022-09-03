# zend-ffi

Provides the base **API** for creating _extensions_, or modifying `Zend/PHP` internal _core_ with FFI.

It allows loading of shared libraries (`.dll` or `.so`), calling of **C functions** and accessing of **C type** data structures in pure `PHP`.

This package breaks down the `Zend extension API` into _PHP classes_ getting direct access to all PHP internal actions. You can actually change PHP default behaviors. You will be able to get the behavior of [componere](http://docs.php.net/manual/en/intro.componere.php) extension with needing it.

There are many extensions on [Pecl](https://pecl.php.net/package-stats.php) that hasn't been updated.

## Installation

```shell
    composer require symplely/zend-ffi
```

`FFI` is enabled by default in `php.ini` since `PHP 7.4`, as to `OpCache`, they should not be changed unless already manually disabled.
Only the `preload` section might need setting up.

```ini
[ffi]
; FFI API restriction. Possible values:
; "preload" - enabled in CLI scripts and preloaded files (default)
; "false"   - always disabled
; "true"    - always enabled
ffi.enable="preload"

; List of headers files to preload, wildcard patterns allowed.
ffi.preload=path/to/.cdef/preload.php
; Or
ffi.preload=path/to/vendor/symplely/zend-ffi/preload.php

zend_extension=opcache
```

```json
{
    "name": "",
// Either
    "preload": {
        "files": [
            "path/to/file.php",
            "..."
        ],
// Or
        "directory": [
            "path/to/directory"
        ]
    }
}
```

## Documentation

The functions in [preload.php](https://github.com/symplely/zend-ffi/blob/main/preload.php) and [Functions.php](https://github.com/symplely/zend-ffi/blob/main/api/Functions.php) should be used or expanded upon.

## Reference/Credits

- [Introduction to PHP FFI](https://dev.to/verkkokauppacom/introduction-to-php-ffi-po3)
- [How to Use PHP FFI in Programming](https://spiralscout.com/blog/how-to-use-php-ffi-in-programming)
- [PHP FFI and what it can do for you](https://phpconference.com/blog/php-ffi-and-what-it-can-do-for-you/)
- [Zend API - Hacking the Core of PHP](https://www.cs.helsinki.fi/u/laine/php/zend.html)
- [PHP Internals Book](https://www.phpinternalsbook.com/index.html)
- [Upgrading PHP extensions from PHP5 to NG](https://wiki.php.net/phpng-upgrading)
- [Extending and Embedding PHP](https://flylib.com/books/en/2.565.1/)
- [Getting Started with PHP-FFI](https://www.youtube.com/watch?v=7pfjvRupoqg) **Youtube**
- [Awesome PHP FFI](https://github.com/gabrielrcouto/awesome-php-ffi)
- [Z-Engine library](https://github.com/lisachenko/z-engine)

### Possible Security Risks

- [Down the FFI Rabbit Hole](https://pwnfirstsear.ch/2020/07/20/0ctf2020-noeasyphp.html)

### The Beginning

- [About Zeev’s proposal of PHP superset](https://william-pinaud.medium.com/about-zeevs-proposal-of-php-superset-9e291f0de630)

## Contributing

Contributions are encouraged and welcome; I am always happy to get feedback or pull requests on Github :) Create [Github Issues](https://github.com/symplely/uv-ffi/issues) for bugs and new features and comment on the ones you are interested in.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
