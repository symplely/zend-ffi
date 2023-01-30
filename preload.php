<?php

declare(strict_types=1);

use FFI\CData;
use FFI\CType;
use ZE\PhpStream;

if (!\defined('MODULE_PERSISTENT')) {
  /**
   * @see zend_modules.h:MODULE_PERSISTENT
   */
  \define('MODULE_PERSISTENT', 1);
}

if (!\defined('MODULE_TEMPORARY')) {
  /**
   * @see zend_modules.h:MODULE_TEMPORARY
   */
  \define('MODULE_TEMPORARY', 2);
}

if (!\defined('DS'))
  \define('DS', \DIRECTORY_SEPARATOR);

if (!\defined('None'))
  \define('None', null);

if (!\defined('INET_ADDRSTRLEN'))
  \define('INET_ADDRSTRLEN', 22);

if (!\defined('INET6_ADDRSTRLEN'))
  \define('INET6_ADDRSTRLEN', 65);

if (!\defined('IS_WINDOWS'))
  \define('IS_WINDOWS', ('\\' === \DS));

if (!\defined('IS_LINUX'))
  \define('IS_LINUX', ('/' === \DS));

if (!\defined('IS_MACOS'))
  \define('IS_MACOS', (\PHP_OS === 'Darwin'));

if (!\defined('EOL'))
  \define('EOL', \PHP_EOL);

if (!\defined('CRLF'))
  \define('CRLF', "\r\n");

if (!\defined('IS_ZTS'))
  \define('IS_ZTS', \ZEND_THREAD_SAFE);

if (!\defined('IS_CLI')) {
  /**
   * Check if php is running from cli (command line).
   */
  \define(
    'IS_CLI',
    \defined('STDIN') ||
      (empty($_SERVER['REMOTE_ADDR']) && !isset($_SERVER['HTTP_USER_AGENT']) && \count($_SERVER['argv']) > 0)
  );
}

if (!\defined('SYS_CONSOLE')) {
  /**
   * O.S. physical __input/output__ console `DEVICE`.
   */
  \define('SYS_CONSOLE', \IS_WINDOWS ? '\\\\?\\CON' : '/dev/tty');
}

if (!\defined('SYS_NULL')) {
  /**
   * O.S. physical __null__ `DEVICE`.
   */
  \define('SYS_NULL', \IS_WINDOWS ? '\\\\?\\NUL' : '/dev/null');
}

if (!\defined('SYS_PIPE')) {
  /**
   * O.S. physical __pipe__ prefix `string name` including trailing slash.
   */
  \define('SYS_PIPE', \IS_WINDOWS ? '\\\\.\\pipe\\' : \getcwd() . '/');
}

if (!\defined('IS_PHP82'))
  \define('IS_PHP82', ((float) \phpversion() >= 8.2));

if (!\defined('IS_PHP81'))
  \define('IS_PHP81', ((float) \phpversion() >= 8.1) && !\IS_PHP82);

if (!\defined('IS_PHP8'))
  \define('IS_PHP8', ((float) \phpversion() >= 8.0));

if (!\defined('IS_PHP80'))
  \define('IS_PHP80', (\IS_PHP8 && !\IS_PHP81));

if (!\defined('IS_PHP74'))
  \define('IS_PHP74', ((float) \phpversion() >= 7.4) && !\IS_PHP8);

if (!\defined('ZEND_MODULE_API_NO'))
  \define(
    'ZEND_MODULE_API_NO',
    \IS_PHP80 ? 20200930
      : (\IS_PHP81 ? 20210902
        : (\IS_PHP82 ? 20220829
          : 20190902
        )
      )
  );

if (!\function_exists('setup_ffi_loader')) {
  function ffi_cdef(string $code, string $lib = null): \FFI
  {
    if (!empty($lib)) {
      return \FFI::cdef($code, $lib);
    } else {
      return \FFI::cdef($code);
    }
  }

  /**
   * @return php_stream
   */
  function stream_stdout(): CData
  {
    return \ffi_object(\Core::get_stdio(1));
  }

  /**
   * @return php_stream
   */
  function stream_stdin(): CData
  {
    return \ffi_object(\Core::get_stdio(0));
  }

  /**
   * @return php_stream
   */
  function stream_stderr(): CData
  {
    return \ffi_object(\Core::get_stdio(2));
  }

  /**
   * Returns **cast** a `zend` pointer as `typedef`.
   *
   * @param string $typedef
   * @param object $ptr
   * @return CData
   */
  function ze_cast(string $typedef, $ptr): CData
  {
    return \Core::cast('ze', $typedef, \ffi_object($ptr));
  }

  /**
   * Returns **cast** a `void*` pointer.
   *
   * @param CData $ptr
   * @return CData void_ptr
   */
  function ffi_void($ptr): CData
  {
    return \FFI::cast('void*', $ptr);
  }

  function ffi_set(string $tag, ?FFI $ffi): void
  {
    \Core::set($tag, $ffi);
  }

  function ffi_get(string $tag): ?\FFI
  {
    return \Core::get($tag);
  }

  /**
   * Returns `C pointer` _addr_ of `C data` _type_.
   *
   * @param CData $ptr
   * @return FFI\CData
   */
  function ffi_ptr(CData $ptr): CData
  {
    return \FFI::addr($ptr);
  }

  /**
   * Convert `C string` to PHP `string`.
   *
   * @param CData $ptr
   * @return string
   */
  function ffi_string(CData $ptr): string
  {
    return \FFI::string($ptr);
  }

  /**
   * Convert PHP `string` to `C string`.
   *
   * @param string $string
   * @param bool $owned
   * @return CData char **pointer** of `string`
   */
  function ffi_char(string $string, bool $owned = false, bool $persistent = false): CData
  {
    $size = \strlen($string);
    $ptr = \FFI::new('char[' . ($size + 1) . ']', $owned, $persistent);
    \FFI::memcpy($ptr, $string, $size);

    return $ptr;
  }

  /**
   * Creates a `char` C data structure of size.
   *
   * @param int $size
   * @param bool $owned
   * @return CData `char` C structure
   */
  function ffi_characters(int $size, bool $owned = true): CData
  {
    $ptr = \FFI::new('char[' . ($size + 1) . ']', $owned);
    return $ptr;
  }

  /**
   * Checks `handle` and returns the `CData` object _pointer_ within by _invoking_.
   *
   * @param object $handle
   * @return CData
   */
  function ffi_object(object $handle): CData
  {
    return ($handle instanceof \ZE || $handle instanceof \CStruct || !\is_cdata($handle))
      ? $handle()
      : $handle;
  }

  function ffi_null(): CData
  {
    return \FFI::cast('void*', 0);
  }

  function ffi_set_free(bool $status): void
  {
    \CStruct::ffi_free_set($status);
  }

  /**
   * Check and manually removes an _list_ of previously created `C` data memory pointer.
   *
   * @param object|CData ...$ptr
   * @return void
   */
  function ffi_free_if(...$ptr): void
  {
    if (\CStruct::is_ffi_free_active()) {
      foreach ($ptr as $cdata) {
        try {
          $object = ($cdata instanceof \ZE || $cdata instanceof \CStruct || !\is_cdata($cdata))
            ? $cdata()
            : $cdata;
          if (\is_cdata($object) && !\FFI::isNull($object))
            \FFI::free($object);
        } catch (\Throwable $e) {
        }
      }
    }
  }

  /**
   * Returns size of C data type of `object` or the given FFI\CData or FFI\CType.
   *
   * @param mixed $object
   * @return integer
   */
  function ffi_sizeof($object): int
  {
    if ($object instanceof \ZE)
      $object = $object();
    elseif ($object instanceof \CStruct)
      return $object->sizeof();
    elseif (!\is_cdata($object) || !$object instanceof CType)
      $object = \zval_stack(0)()[0];

    return \FFI::sizeof($object);
  }

  /**
   * Returns the _CType_ **string** representing the `FFI\CData` object.
   *
   * @param CData $ptr
   * @return string
   */
  function ffi_str_typeof(CData $ptr): string
  {
    return \trim(\str_replace(['FFI\CType:', ' Object'], '', \print_r(\FFI::typeof($ptr), true)));
  }

  /**
   * @return \FFI global interface to _PHP/Zend_ **_C_** library.
   */
  function ze_ffi(): \FFI
  {
    return \Core::get('ze');
  }

  function misc_ffi(): \FFI
  {
    return \Core::get('misc');
  }

  /**
   * @return \FFI global interface to _PThreads_ **_C_** library.
   */
  function ts_ffi(): \FFI
  {
    return \Core::get('ts');
  }

  /**
   * Checks whether the given `FFI\CData` object __C type__, it's *typedef* are equal.
   *
   * @param CData $ptr
   * @param string $ctype typedef
   * @return boolean
   */
  function is_typeof(CData $ptr, string $ctype): bool
  {
    return \ffi_str_typeof($ptr) === $ctype;
  }

  /**
   * Checks whether the given object is `FFI\CData`.
   *
   * @param mixed $ptr
   * @return boolean
   */
  function is_cdata($ptr): bool
  {
    return $ptr instanceof CData;
  }

  /**
   * Checks whether the `FFI\CData` is a null pointer.
   *
   * @param object $ptr
   * @return boolean
   */
  function is_null_ptr(object $ptr): bool
  {
    try {
      return \FFI::isNull(\ffi_object($ptr));
    } catch (\Throwable $e) {
      return true;
    }
  }

  /**
   * Check for _active_ `PHP Engine` **ffi** instance
   *
   * @return boolean
   */
  function is_ze_ffi(): bool
  {
    return \Core::get('ze') instanceof \FFI;
  }

  /**
   * Check for _active_ `pthreads` **ffi** instance
   *
   * @return boolean
   */
  function is_ts_ffi(): bool
  {
    return \Core::get('ts') instanceof \FFI;
  }

  /**
   * Temporary enable `cli` if needed to preform a the `routine` call.
   *
   * @param callable $routine
   * @param mixed ...$arguments
   * @return mixed
   */
  function cli_direct(callable $routine, ...$arguments)
  {
    $cdata = \ze_ffi()->sapi_module;
    $old = \ffi_string($cdata->name);
    $changed = false;
    if ($old !== 'cli') {
      $changed = true;
      $cdata->name = \ffi_char('cli');
    }

    $result = $routine(...$arguments);
    if ($changed)
      $cdata->name = \ffi_char($old);

    return $result;
  }

  function bail_if_fail($X, string $file, int $lineno)
  {
    if (($X) != 0)
      \ze_ffi()->_zend_bailout($file, $lineno);
  }

  /**
   * Temporary enable `cli` if needed to preform a `php://fd/` **_php_stream_open_wrapper_ex()** call.
   * - Same as `zval_fd_direct()` but returns underlying Zend **php_stream** _C structure_ of `resource`.
   *
   * @param integer $resource fd number
   * @return PhpStream
   */
  function php_stream_direct(int $resource): ?PhpStream
  {
    return \cli_direct(function (int $type) {
      $fd = \Core::get_stdio($type);
      if ($fd === null) {
        return PhpStream::open_wrapper('php://fd/' . $type, '', 0);
      }

      return $fd;
    }, $resource);
  }

  /**
   * Gets class name
   *
   * @param object $handle
   * @return string
   */
  function reflect_object_name(object $handle): string
  {
    return (new \ReflectionObject($handle))->getName();
  }

  /**
   * Converts a **class** instance `method` into a _closure_.
   *
   * @param object $class instance
   * @param string $method callable
   * @return \Closure
   */
  function closure_from(object $class, string $method): \Closure
  {
    return \Closure::fromCallable([$class, $method]);
  }

  /**
   * Converts the unsigned integer netlong from network byte order to host byte order.
   *
   * @param mixed $str
   * @return int
   */
  function ntohl(...$str)
  {
    return \unpack('I', \pack('N', ...$str))[1];
  }

  /**
   * Converts the unsigned integer hostlong from host byte order to network byte order.
   *
   * @param mixed $str
   * @return int
   */
  function htonl(...$str)
  {
    return \unpack('N', \pack('I', ...$str))[1];
  }

  /**
   * Converts the unsigned short integer netshort from network byte order to host byte order.
   *
   * @param mixed $str
   * @return int
   */
  function ntohs(...$str)
  {
    return \unpack('S', \pack('n', ...$str))[1];
  }

  /**
   * Converts the unsigned short integer hostshort from host byte order to network byte order.
   *
   * @param mixed $str
   * @return int
   */
  function htons(...$str)
  {
    return \unpack('n', \pack('S', ...$str))[1];
  }

  /**
   * Creates/returns `C data` **int** base _typedef_, a generic `FFI` _CStruct_ class _instance_.
   *
   * @param string $typedef
   * @param string $ffi_tag
   * @param int $value
   * @param boolean $owned
   * @param boolean $persistent
   * @return \CStruct
   */
  function c_int_type(
    string $typedef,
    string $ffi_tag = 'ze',
    $value = null,
    bool $owned = true,
    bool $persistent = false
  ): \CStruct {
    return \CStruct::integer_init($typedef, $ffi_tag, $value, $owned, $persistent);
  }

  /**
   * Creates/returns `C data` **struct** base _typedef_, a generic `FFI` _CStruct_ class _instance_.
   *
   * @param string $typedef
   * @param string $ffi_tag
   * @param array|null $values
   * @param boolean $owned
   * @param boolean $persistent
   * @return \CStruct
   */
  function c_struct_type(
    string $typedef,
    string $ffi_tag = 'ze',
    array $values = null,
    bool $owned = true,
    bool $persistent = false
  ): \CStruct {
    return \CStruct::struct_init($typedef, $ffi_tag, $values, $owned, $persistent);
  }

  /**
   * Creates/returns `C data` **type** _typedef_, a generic `FFI` _CStruct_ class _instance_.
   *
   * @param string $type
   * @param string $ffi_tag
   * @param boolean $owned
   * @param boolean $persistent
   * @return \CStruct
   */
  function c_typedef(
    string $type,
    string $ffi_tag = 'ze',
    bool $owned = true,
    bool $persistent = false
  ): \CStruct {
    return \CStruct::type_init($type, $ffi_tag, $owned, $persistent);
  }

  /**
   * Creates/return `C data` **array** base _typedef_, a generic `FFI` _CStruct_ class _instance_.
   *
   * @param string $typedef
   * @param string $ffi_tag
   * @param integer $size
   * @param boolean $owned
   * @param boolean $persistent
   * @return \CStruct
   */
  function c_array_type(
    string $typedef,
    string $ffi_tag = 'ze',
    int $size = 1,
    bool $owned = true,
    bool $persistent = false
  ): \CStruct {
    return \CStruct::array_init($typedef, $ffi_tag, $size, $owned, $persistent);
  }

  function ze_init(): void
  {
    if (!\is_ze_ffi()) {
      // Try if preloaded
      try {
        \Core::set('ze', \FFI::scope("__zend__"));
        \Core::scope_set();
      } catch (\Throwable $e) {
        \zend_preloader();
      }

      if (!\is_ze_ffi()) {
        throw new \RuntimeException("FFI parse failed!");
      }
    }
  }

  /**
   * @param string $tag name for a **FFI** `instance`
   * @param string $cdef_file C header file for `\FFI::load`
   * @return void
   */
  function setup_ffi_loader(string $tag, string $cdef_file): void
  {
    \Core::set($tag, \FFI::load($cdef_file));
  }

  function zend_preloader(): void
  {
    $minor = \IS_PHP81 ? '1' : (\IS_PHP82 ? '2' : '');
    $os = __DIR__ . \DS . (\PHP_OS_FAMILY === 'Windows' ? 'headers\zeWin' : 'headers/ze');
    $php = $os . \PHP_MAJOR_VERSION . $minor . (\PHP_ZTS ? 'ts' : '') . '.h';
    \setup_ffi_loader('ze', $php);

    if (\IS_WINDOWS) {
      $mmap_header = __DIR__ . '\\headers\\windows_mman.h';
      if (\file_exists('vendor\\symplely\\zend-ffi')) {
        $vendor_code = \str_replace('.h', '_vendor.h', $mmap_header);
        if (!\file_exists($vendor_code)) {
          $file = \str_replace(
            'FFI_LIB ".',
            'FFI_LIB "vendor\\\symplely\\\zend-ffi',
            \file_get_contents($mmap_header)
          );

          \file_put_contents(
            $vendor_code,
            $file,
            \LOCK_EX
          );
        }

        $mmap_header = $vendor_code;
      }

      \setup_ffi_loader('misc', $mmap_header);
    }

    if (\file_exists('.' . \DS . 'ffi_extension.json')) {
      $loader = function ($iterator, bool $isDir) {
        foreach ($iterator as $fileInfo) {
          if ($isDir && !$fileInfo->isFile())
            continue;

          $file = $isDir ? $fileInfo->getPathname() : $fileInfo;
          include_once $file;
        }
      };

      $preload_list = \json_decode(\file_get_contents('.' . \DS . 'ffi_extension.json'), true);
      if (isset($preload_list['preload']['directory'])) {
        foreach ($preload_list['preload']['directory'] as $directory) {
          $dir = new \RecursiveDirectoryIterator($directory, \RecursiveDirectoryIterator::KEY_AS_PATHNAME);
          $iterator = new \RecursiveIteratorIterator($dir, \RecursiveIteratorIterator::SELF_FIRST);
          $loader($iterator, true);
        }
      }

      if (isset($preload_list['preload']['files'])) {
        $loader($preload_list['preload']['files'], false);
      }

      if (\PHP_ZTS) {
        try {
          \Core::set('ts', \FFI::scope("__threads__"));
        } catch (\Throwable $e) {
          $dir = __DIR__;
          if (\IS_WINDOWS)
            $header =  $dir . '\\headers\\windows_pthreads.h';
          elseif (\file_exists($dir . '/headers/linux_pthreads.h'))
            $header = $dir . '/headers/linux_pthreads.h';
          else {
            $platform = null;
            if (\PHP_OS == 'Darwin')
              $platform .= '/usr/lib/libpthread.dylib';
            elseif (\php_uname('m') == 'aarch64')
              $platform .= '/usr/lib/aarch64-linux-gnu/libpthread.so';
            else {
              $header = null;
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

              $like = \trim((string) $os['ID_LIKE']);
              if ($like == 'debian')
                $platform = '/lib/x86_64-linux-gnu/libpthread.so.0';
              elseif ($like == 'redhat')
                $platform = '/usr/lib64/libpthread.so';
            }

            if (!\is_null($platform)) {
              \file_put_contents(
                $dir . '/headers/linux_pthreads.h',
                \str_replace(
                  '__platforms_pthread_library_location__',
                  $platform,
                  \file_get_contents($dir . '/headers/linux_native_threads.h')
                ),
                \LOCK_EX
              );

              $header = $dir . '/headers/linux_pthreads.h';
            }
          }

          if (\file_exists('vendor\\symplely\\zend-ffi') && \IS_WINDOWS) {
            $vendor_code = \str_replace('.h', '_vendor.h', $header);
            if (!\file_exists($vendor_code)) {
              $file = \str_replace(
                'FFI_LIB ".',
                'FFI_LIB "vendor\\\symplely\\\zend-ffi',
                \file_get_contents($header)
              );

              \file_put_contents(
                $vendor_code,
                $file,
                \LOCK_EX
              );
            }

            $header = $vendor_code;
          }

          \setup_ffi_loader('ts', $header);
        }
      }
    }

    if (\PHP_ZTS)
      \tsrmls_cache_define();
  }

  function tsrmls_cache_define()
  {
    if (\PHP_ZTS) {
      global $_tsrm_ls_cache;
      $_tsrm_ls_cache = null;
    }
  }

  function tsrmls_cache_update()
  {
    if (\PHP_ZTS) {
      global $_tsrm_ls_cache;
      $_tsrm_ls_cache = \ze_ffi()->tsrm_get_ls_cache();
    }
  }

  function tsrmls_cache(): ?CData
  {
    if (\PHP_ZTS) {
      global $_tsrm_ls_cache;
      return $_tsrm_ls_cache;
    }

    return null;
  }

  function tsrmls_activate()
  {
    if (\PHP_ZTS) {
      \ze_ffi()->ts_resource_ex(0, null);
      \tsrmls_cache_update();
    }
  }

  function tsrmls_deactivate()
  {
    if (\PHP_ZTS) {
      \ze_ffi()->ts_free_id(0);
      \tsrmls_cache_define();
    }
  }

  \ze_init();
}
