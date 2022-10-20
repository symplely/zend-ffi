<?php

declare(strict_types=1);

use FFI\CData;
use FFI\CType;
use ZE\PhpStream;

if (!\defined('DS'))
  \define('DS', \DIRECTORY_SEPARATOR);

if (!\defined('IS_PHP81'))
  \define('IS_PHP81', ((float) \phpversion() >= 8.1));

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
    return \ffi_object(Core::get_stdio(1));
  }

  /**
   * @return php_stream
   */
  function stream_stdin(): CData
  {
    return \ffi_object(Core::get_stdio(0));
  }

  /**
   * @return php_stream
   */
  function stream_stderr(): CData
  {
    return \ffi_object(Core::get_stdio(2));
  }

  function ze_init(): void
  {
    \Core::init_zend();
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
    $handler = $handle;
    if ($handle instanceof \ZE || $handle instanceof \CStruct || !\is_cdata($handle))
      $handler = $handle();

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
   * @return \FFI global **zend/php _C data_** structures:
   *
   * @property zend_internal_function $zend_pass_function
   * @property zend_object_handlers $std_object_handlers
   * @property HashTable $module_registry
   * @property sapi_module_struct sapi_module
   * @property int $compiler_globals_id if ZTS
   * @property size_t $compiler_globals_offset if ZTS
   * @property zend_compiler_globals $compiler_globals if NTS
   * @property int sapi_globals_id if ZTS
   * @property size_t sapi_globals_offset if ZTS
   * @property sapi_globals_struct sapi_globals if NTS
   * @property int $executor_globals_id; if ZTS
   * @property size_t $executor_globals_offset; if ZTS
   * @property zend_execute_data $executor_globals; if NTS
   * @property int core_globals_id; if ZTS
   * @property size_t core_globals_offset; if ZTS
   * @property _php_core_globals core_globals; if NTS
   * @property php_stream_ops php_stream_stdio_ops;
   * @property php_stream_wrapper php_plain_files_wrapper;
   * @property zend_fcall_info empty_fcall_info;
   * @property zend_fcall_info_cache empty_fcall_info_cache;
   */
  function ze_ffi(): \FFI
  {
    return \Core::get('ze');
  }

  function win_ffi(): \FFI
  {
    return \Core::get('win');
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
    return \Core::is_null($ptr);
  }

  /**
   * Check for _active_ `PHP Engine` **ffi** instance
   *
   * @return boolean
   */
  function is_ze_ffi(): bool
  {
    return \Core::is_ze_ffi();
  }

  /**
   * Check for _active_ `Windows` **ffi** instance
   *
   * @return boolean
   */
  function is_win_ffi(): bool
  {
    return \Core::is_win_ffi();
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
   * Converts a **class** instance `method` into a _closure_.
   *
   * @param object $class instance
   * @param string $method callable
   * @return \Closure
   */
  function closure_call(object $class, string $method): \Closure
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
    $minor = \IS_PHP81 ? '1' : '';
    $os = __DIR__ . \DS . (\PHP_OS_FAMILY === 'Windows' ? 'headers\zeWin' : 'headers/ze');
    $php = $os . \PHP_MAJOR_VERSION . $minor . (\PHP_ZTS ? 'ts' : '') . '.h';
    \setup_ffi_loader('ze', $php);
    if (\file_exists('.' . \DS . 'ffi_extension.json')) {
      $ext_list = \json_decode(\file_get_contents('.' . \DS . 'ffi_extension.json'), true);
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

    if (\PHP_ZTS)
      \tsrmls_cache_define();
  }

  function win_ffi_loader(string $winFile = '.\\headers\\msvcrt.h'): void
  {
    if (!(defined('STD_INPUT_HANDLE'))) {
      /**
       * The standard input device. Initially, this is the console input buffer.
       */
      \define('STD_INPUT_HANDLE', -10);
    }

    if (!(defined('STD_OUTPUT_HANDLE'))) {
      /**
       * The standard output device. Initially, this is the active console screen buffer.
       */
      \define('STD_OUTPUT_HANDLE', -11);
    }

    if (!(defined('STD_ERROR_HANDLE'))) {
      /**
       * The standard error device. Initially, this is the active console screen buffer.
       */
      \define('STD_ERROR_HANDLE', -12);
    }

    \setup_ffi_loader('win', $winFile);
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

  \zend_preloader();
}
