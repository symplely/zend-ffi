<?php

declare(strict_types=1);

use FFI\CData;
use FFI\CType;
use ZE\ZendString;

if (!\defined('None'))
  \define('None', null);

if (!\defined('DS'))
  \define('DS', \DIRECTORY_SEPARATOR);

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
   * The OS physical _input/output_ console `DEVICE`.
   */
  \define('SYS_CONSOLE', \IS_WINDOWS ? '\\\\?\\CON' : '/dev/tty');
}

if (!\defined('SYS_NULL')) {
  /**
   * The OS physical _null_ `DEVICE`.
   */
  \define('SYS_NULL', \IS_WINDOWS ? '\\\\?\\NUL' : '/dev/null');
}

if (!\defined('IS_PHP81'))
  \define('IS_PHP81', ((float) \phpversion() >= 8.1));

if (!\defined('IS_PHP8'))
  \define('IS_PHP8', ((float) \phpversion() >= 8.0));

if (!\defined('IS_PHP74'))
  \define('IS_PHP74', ((float) \phpversion() >= 7.4) && !\IS_PHP8);

if (!\function_exists('preloader')) {
  function ffi_cdef(string $code, string $lib = null): \FFI
  {
    if (!empty($lib)) {
      return \FFI::cdef($code, $lib);
    } else {
      return \FFI::cdef($code);
    }
  }

  /**
   * @return php_stream|null
   */
  function stream_stdout(): ?CData
  {
    return Core::get_stdio(1)();
  }

  /**
   * @return php_stream|null
   */
  function stream_stdin(): ?CData
  {
    return Core::get_stdio(0)();
  }

  /**
   * @return php_stream|null
   */
  function stream_stderr(): ?CData
  {
    return Core::get_stdio(2)();
  }

  function zend_init(): void
  {
    Core::init_zend();
  }

  /**
   * Returns **cast** a `zend` pointer as `typedef`.
   *
   * @param string $typedef
   * @param object $ptr
   * @return CData
   */
  function zend_cast(string $typedef, $ptr): CData
  {
    return Core::cast('ze', $typedef, \ffi_object($ptr));
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
  function ffi_char(string $string, bool $owned = false): CData
  {
    $size = \strlen($string);
    $ptr = \FFI::new('char[' . ($size + 1) . ']', $owned);
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
   * Checks `instance` and returns the `CData` object within.
   *
   * @param object $handle
   * @return CData
   */
  function ffi_object(object $handle): CData
  {
    $handler = $handle;
    try {
      if ($handle instanceof ZE || !\is_cdata($handle))
        $handler = $handle();
    } catch (\Throwable $e) {
    }

    return $handler;
  }

  /**
   * Manually removes an previously created `C` data memory pointer.
   *
   * @param CData $ptr
   * @return void
   */
  function ffi_free(object $ptr): void
  {
    \FFI::free(\ffi_object($ptr));
  }

  /**
   * This function returns the **string** of the `FFI\CType object`,
   * representing the type of the given `FFI\CData object`.
   *
   * @param CData $ptr
   * @return string
   */
  function ffi_str_typeof(CData $ptr): string
  {
    return \trim(\str_replace(['FFI\CType:', ' Object'], '', \print_r(\FFI::typeof($ptr), true)));
  }

  /**
   * @return \FFI **_global zend C structures_:**
   *
   * @property zend_internal_function $zend_pass_function
   * @property zend_object_handlers $std_object_handlers
   * @property HashTable $module_registry
   * @property size_t $compiler_globals_offset if ZTS
   * @property size_t $executor_globals_offset if ZTS
   * @property zend_execute_data $executor_globals if NTS
   * @property zend_compiler_globals $compiler_globals if NTS
   * @property php_stream_ops php_stream_stdio_ops;
   * @property php_stream_wrapper php_plain_files_wrapper;
   * @property szend_module_struct szend_module;
   * @property zend_fcall_info empty_fcall_info;
   * @property zend_fcall_info_cache empty_fcall_info_cache;
   */
  function ze_ffi(): \FFI
  {
    return Core::get('ze');
  }

  function win_ffi(): \FFI
  {
    return Core::get('win');
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
    return Core::is_null($ptr);
  }

  /**
   * Check for _active_ `PHP Engine` **ffi** instance
   *
   * @return boolean
   */
  function is_ze_ffi(): bool
  {
    return Core::is_ze_ffi();
  }

  /**
   * Check for _active_ `Windows` **ffi** instance
   *
   * @return boolean
   */
  function is_win_ffi(): bool
  {
    return Core::is_win_ffi();
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
   * Undocumented function
   *
   * @param string $tag name for a **FFI** `instance`
   * @param string $cdef_file C header file for `\FFI::load`
   * @return void
   */
  function setup_ffi_loader(string $tag, string $cdef_file): void
  {
    Core::set($tag, \FFI::load($cdef_file));
  }

  function ze_ffi_loader(): void
  {
    $minor = \IS_PHP81 ? '1' : '';
    $os = \PHP_OS_FAMILY === 'Windows' ? '.\headers\zeWin' : './headers/ze';
    $php = $os . \PHP_MAJOR_VERSION . $minor . (\PHP_ZTS ? 'ts' : '') . '.h';
    \setup_ffi_loader('ze', $php);
  }

  function win_ffi_loader(): void
  {
    \setup_ffi_loader('win', '.\\headers\\msvcrt.h');
  }

  function preloader(): void
  {
    Core::init_zend();
    if (\file_exists('.' . \DS . 'zend.json')) {
      $ext_list = \json_decode(\file_get_contents('.' . \DS . 'zend.json'), true);
      $isDir = false;
      $iterator = [];
      $is_opcache_cli = \ini_get('opcache.enable_cli') === '1';
      if (isset($ext_list['preload']['directory'])) {
        $isDir = true;
        $directory = \array_shift($ext_list['preload']['directory']);
        $dir = new \RecursiveDirectoryIterator($directory, \RecursiveDirectoryIterator::KEY_AS_PATHNAME);
        $iterator = new \RecursiveIteratorIterator($dir, \RecursiveIteratorIterator::SELF_FIRST);
      } elseif (isset($ext_list['preload']['files'])) {
        $iterator = $ext_list['preload']['files'];
      }

      foreach ($iterator as $fileInfo) {
        if ($isDir && !$fileInfo->isFile()) {
          continue;
        }

        $file = $isDir ? $fileInfo->getPathname() : $fileInfo;
        if ($is_opcache_cli) {
          if (!\opcache_is_script_cached($file))
            \opcache_compile_file($file);
        } else {
          include_once $file;
        }
      }
    }
  }

  \preloader();
}
