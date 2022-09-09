<?php

declare(strict_types=1);

namespace ZE;

use ZE;
use FFI\CData;
use ZE\Zval;
use ZE\Resource;
use ZE\ZendResource;

if (!\class_exists('PhpStream')) {
    final class PhpStream extends Resource
    {
        public static function init(string $type = null): self
        {
            return new static('struct _php_stream', false);
        }

        /**
         * Represents `php_stream_to_zval()` _macro_.
         *
         * Use this to assign the stream to a zval and tell the stream that is
         * has been exported to the engine; it will expect to be closed automatically
         * when the resources are auto-destructed.
         *
         * @param \php_stream $ptr
         * @return Zval
         */
        public static function init_stream(CData $ptr): Zval
        {
            if (!\is_typeof($ptr, 'struct _php_stream*')) {
                return \ze_ffi()->zend_error(
                    \E_WARNING,
                    'Only STREAM resource type is accepted, detected: (%s)',
                    \ffi_str_typeof($ptr)
                );
            }

            $res = \zend_register_resource($ptr, \ze_ffi()->php_file_le_stream());
            $zval = Zval::init();
            $zval->macro(ZE::RES_P, $res);

            return $zval;
        }

        /**
         * @param string $path filename or URL to be opened for _reading_, _writing_, or both depending on the value of `mode`
         * @param string $mode
         * @param integer $options
         * - `ZE::USE_PATH `- Relative paths will be applied to the locations specified in the .ini option include_path. This option is specified by the built-in fopen() function when the third parameter is passed as TRUE.
         * - `ZE::STREAM_USE_URL` - When set, only remote URLs will be opened. Wrappers that are not flagged as remote URLs such as file://, php://, compress.zlib://, and compress.bzip2:// will result in failure.
         * - `ZE::ENFORCE_SAFE_MODE` - Despite the naming of this constant, safe mode checks are only truly enforced if this option is set, and the corresponding safe_mode ini directive has been enabled. Excluding this option causes safe_mode checks to be skipped regardless of the INI setting.
         * - `ZE::REPORT_ERRORS` - If an error is encountered during the opening of the specified resource, an error will only be generated if this flag is passed.
         * - `ZE::STREAM_MUST_SEEK` - Some streams, such as socket transports, are never seekable; others, such as file handles, are only seekable under certain circumstances. If a calling scope specifies this option and the wrapper determines that it cannot guarantee seekability, it will refuse to open the stream.
         * - `ZE::STREAM_WILL_CAST` - If the calling scope will require the stream to be castable to a stdio or posix file descriptor, it should pass this option to the open_wrapper function so that it can fail gracefully before I/O operations have begun.
         * - `ZE::STREAM_ONLY_GET_HEADERS` - Indicates that only metadata will be requested from the stream. In practice this is used by the http wrapper to populate the http_response_headers global variable without actually fetching the contents of the remote file.
         * - `ZE::STREAM_DISABLE_OPEN_BASEDIR` - Like the safe_mode check, this option, even when absent, still requires the open_basedir ini option to be enabled for checks to be performed. Specifying it as an option simply allows the default check to be bypassed.
         * - `ZE::STREAM_OPEN_PERSISTENT` - Instructs the streams layer to allocate all internal structures persistently and register the associated resource in the persistent list.
         * - `ZE::IGNORE_PATH` - If not specified, the default include path will be searched. Most URL wrappers ignore this option.
         * - `ZE::IGNORE_URL` - When provided, only local files will be opened by the streams layer. All is_url wrappers will be ignored.
         * @param object|null $opened
         * @param object|null $context
         * @return self
         */
        public static function open_wrapper(
            string $path,
            string $mode,
            int $options,
            ?object $opened = null,
            ?object $context = null
        ): self {
            return static::init_value(
                \ze_ffi()->_php_stream_open_wrapper_ex(
                    $path,
                    $mode,
                    $options,
                    $opened,
                    $context
                )
            );
        }

        /**
         * Represents `ext-uv` _macro_ `PHP_UV_FD_TO_ZVAL()`.
         *
         * @param int $fd
         * @param string $mode
         * @param bool $getZval
         * @return resource|Zval
         */
        public static function fd_to_zval($fd, $mode = 'wb+', bool $getZval = false)
        {
            $zval = PhpStream::get_fd($fd, true);
            $resource = null;
            if (!$zval instanceof Zval) {
                $stream = \ze_ffi()->_php_stream_fopen_from_fd($fd, $mode, null);
                try {
                    $zval = PhpStream::init_stream($stream);
                    /** @var PhpStream */
                    $php_stream = static::init_value($stream);
                    $resource = \zval_native($zval);
                    $php_stream->add_pair($zval, $fd, (int)$resource);
                } catch (\Throwable $e) {
                    return \ze_ffi()->_php_stream_free($stream, self::PHP_STREAM_FREE_CLOSE);
                }
            }

            if ($getZval)
                return $zval;

            return \is_null($resource) ? \zval_native($zval) : $resource;
        }

        public static function php_stream_from_zval(Zval $pZval)
        {
            if (($stream = \ze_ffi()->cast(
                'php_stream*',
                \ze_ffi()->zend_fetch_resource2_ex(
                    $pZval(),
                    "stream",
                    \ze_ffi()->php_file_le_stream(),
                    \ze_ffi()->php_file_le_pstream()
                )
            )) == NULL) {
                return;
            }

            return static::init_value($stream);
        }

        public static function php_stream_from_res(ZendResource $res)
        {
            if (($stream = \ze_ffi()->cast('php_stream*', \ze_ffi()->zend_fetch_resource2(
                $res(),
                "stream",
                \ze_ffi()->php_file_le_stream(),
                \ze_ffi()->php_file_le_pstream()
            ))) == NULL) {
                return;
            }

            return static::init_value($stream);
        }

        /**
         * @param Zval $ptr
         * @return int|uv_file `fd`
         */
        public static function zval_to_fd(Zval $ptr, bool $isStream = false): int
        {
            $fd = -1;
            if ($ptr->macro(ZE::TYPE_P) === ZE::IS_RESOURCE) {
                $handle = $ptr()->value->res->handle;
                $zval_fd = Resource::get_fd($handle, true);
                if ($zval_fd instanceof Zval)
                    return !$isStream ? Resource::get_fd($handle, false, true) : Resource::get_fd($handle, false, false, true);

                $zval_fd = \fd_type();
                $fd = $zval_fd();
                $stream = \ze_ffi()->cast(
                    'php_stream*',
                    \ze_ffi()->zend_fetch_resource2($ptr()->value->res, 'stream', \ze_ffi()->php_file_le_stream(), \ze_ffi()->php_file_le_pstream())
                );

                if (\is_cdata($stream)) {
                    if (
                        (\ze_ffi()->_php_stream_cast(
                            $stream,
                            self::PHP_STREAM_AS_FD | self::PHP_STREAM_CAST_INTERNAL,
                            \ffi_void($fd),
                            1
                        ) != ZE::SUCCESS)
                        || $fd < 0
                    ) {
                        $fd = -1;
                    }
                } else {
                    \ze_ffi()->zend_error(\E_WARNING, "unhandled resource type detected.");
                    $fd = -1;
                }

                if ($fd === -1)
                    unset($zval_fd);
            } elseif ($ptr->macro(ZE::TYPE_P) === ZE::IS_LONG) {
                $fd = $ptr->macro(ZE::LVAL_P);
                if ($fd < 0) {
                    $fd = -1;
                    \ze_ffi()->zend_error(\E_WARNING, "invalid resource type detected");
                }
            }

            if (\is_cdata($fd)) {
                $zval_fd->add_pair($ptr, $fd[0], $handle);
                return $fd[0];
            }

            return $fd;
        }

        /**
         * @param Zval $fd
         * @param Zval $stream
         * @return mixed
         */
        public static function check_valid_fd($fd, $stream)
        {
            if ($fd < 0) {
                \ze_ffi()->zend_error(\E_WARNING, "invalid variable passed. can't convert to fd.");
                $stream->free();
                return false;
            }

            if ($fd->macro(ZE::TYPE_INFO_P) === ZE::IS_UNDEF) {
                $fd->copy($stream());
            }

            $fd->native_value($resource);

            return $resource;
        }

        /**
         * @param Zval $ptr
         * @return php_socket_t|int
         */
        public static function zval_to_fd_select(Zval $ptr, string $fd_type = 'php_socket_t')
        {
            $fd = -1;
            // Validate Checks
            if ($ptr->macro(\ZE::TYPE_P) === \ZE::IS_RESOURCE) {
                $handle = $ptr()->value->res->handle;
                $zval_fd = Resource::get_fd($handle, true);
                if ($zval_fd instanceof Zval) {
                    $fd = Resource::get_fd($handle);
                    return $fd[0];
                }

                $zval_fd = \fd_type($fd_type);
                $fd = $zval_fd();
                $stream = \ze_ffi()->cast(
                    'php_stream*',
                    \ze_ffi()->zend_fetch_resource_ex($ptr(), null, \ze_ffi()->php_file_le_stream())
                );

                if (\is_cdata($stream)) {
                    /* make sure only valid resource streams are passed - plainfiles and most php streams are invalid */
                    if (
                        \is_cdata($stream->wrapper)
                        && !\strcmp($stream->wrapper->wops->label, "PHP")
                        && (!$stream->orig_path || (\strncmp($stream->orig_path, "php://std", \strlen("php://std"))
                            && \strncmp($stream->orig_path, "php://fd", \strlen("php://fd"))))
                    ) {
                        \ze_ffi()->zend_error(\E_WARNING, "invalid resource passed, this resource is not supported");
                        return -1;
                    } elseif (\ze_ffi()->_php_stream_cast(
                        $stream,
                        /* Some streams (specifically STDIO and encrypted streams) can be cast to FDs */
                        Resource::PHP_STREAM_AS_FD_FOR_SELECT | Resource::PHP_STREAM_CAST_INTERNAL,
                        \ffi_void($fd),
                        1
                    ) == \ZE::SUCCESS && $fd >= 0) {
                        if (\is_cdata($stream->wrapper) && !\strcmp($stream->wrapper->wops->label, "plainfile")) {
                            $isFIFO = false;
                            if (!\IS_WINDOWS) {
                                $stat = \fstat(\zval_native($ptr));
                                $isFIFO = isset($stat['mode']) && (($stat['mode'] & \S_IFMT) == \S_IFIFO);
                            }

                            if (!$isFIFO) {
                                \ze_ffi()->zend_error(\E_WARNING, "invalid resource passed, this plain files are not supported");
                                $fd = -1;
                            }
                        }
                    } else {
                        $fd = -1;
                    }
                } else {
                    \ze_ffi()->zend_error(\E_WARNING, "unhandled resource type detected.");
                    $fd = -1;
                }
            }

            if (\is_cdata($fd)) {
                $zval_fd->add_pair($ptr, $fd[0], $handle);
                return $fd[0];
            } elseif ($fd === -1) {
                unset($zval_fd);
            }

            return $fd;
        }
    }
}
