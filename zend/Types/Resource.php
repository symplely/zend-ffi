<?php

declare(strict_types=1);

namespace ZE;

use FFI\CData;
use ZE\Zval;

if (!\class_exists('Resource')) {
    class Resource extends \ZE
    {
        /** Wrappers support */
        const IGNORE_PATH                     = 0x00000000;
        const USE_PATH                        = 0x00000001;
        const IGNORE_URL                      = 0x00000002;
        const REPORT_ERRORS                   = 0x00000008;

        /** If you don't need to write to the stream, but really need to
         * be able to seek, use this flag in your options. */
        const STREAM_MUST_SEEK                = 0x00000010;
        /** If you are going to end up casting the stream into a FILE* or
         * a socket, pass this flag and the streams/wrappers will not use
         * buffering mechanisms while reading the headers, so that HTTP
         * wrapped streams will work consistently.
         * If you omit this flag, streams will use buffering and should end
         * up working more optimally.
         * */
        const STREAM_WILL_CAST                = 0x00000020;

        /** this flag applies to php_stream_locate_url_wrapper */
        const STREAM_LOCATE_WRAPPERS_ONLY     = 0x00000040;

        /** this flag is only used by include/require functions */
        const STREAM_OPEN_FOR_INCLUDE         = 0x00000080;

        /** this flag tells streams to ONLY open urls */
        const STREAM_USE_URL                  = 0x00000100;

        /** this flag is used when only the headers from HTTP request are to be fetched */
        const STREAM_ONLY_GET_HEADERS         = 0x00000200;

        /** don't apply open_basedir checks */
        const STREAM_DISABLE_OPEN_BASEDIR     = 0x00000400;

        /** get (or create) a persistent version of the stream */
        const STREAM_OPEN_PERSISTENT          = 0x00000800;

        /** use glob stream for directory open in plain files stream */
        const STREAM_USE_GLOB_DIR_OPEN        = 0x00001000;

        /** don't check allow_url_fopen and allow_url_include */
        const STREAM_DISABLE_URL_PROTECTION   = 0x00002000;

        /** assume the path passed in exists and is fully expanded, avoiding syscalls */
        const STREAM_ASSUME_REALPATH          = 0x00004000;

        /** Allow blocking reads on anonymous pipes on Windows. */
        const STREAM_USE_BLOCKING_PIPE        = 0x00008000;

        /** call ops->close */
        const PHP_STREAM_FREE_CALL_DTOR         = 1;
        /** pefree(stream) */
        const PHP_STREAM_FREE_RELEASE_STREAM    = 2;
        /** tell ops->close to not close it's underlying handle */
        const PHP_STREAM_FREE_PRESERVE_HANDLE   = 4;
        /** called from the resource list dtor */
        const PHP_STREAM_FREE_RSRC_DTOR         = 8;
        /** manually freeing a persistent connection */
        const PHP_STREAM_FREE_PERSISTENT        = 16;
        /** don't close the enclosing stream instead */
        const PHP_STREAM_FREE_IGNORE_ENCLOSING  = 32;
        /** keep associated zend_resource */
        const PHP_STREAM_FREE_KEEP_RSRC         = 64;

        const PHP_STREAM_FREE_CLOSE             = (self::PHP_STREAM_FREE_CALL_DTOR | self::PHP_STREAM_FREE_RELEASE_STREAM);
        const PHP_STREAM_FREE_CLOSE_CASTED      = (self::PHP_STREAM_FREE_CLOSE | self::PHP_STREAM_FREE_PRESERVE_HANDLE);
        const PHP_STREAM_FREE_CLOSE_PERSISTENT  = (self::PHP_STREAM_FREE_CLOSE | self::PHP_STREAM_FREE_PERSISTENT);

        const PHP_STREAM_FLAG_NO_SEEK            = 0x1;
        const PHP_STREAM_FLAG_NO_BUFFER          = 0x2;

        const PHP_STREAM_FLAG_EOL_UNIX            = 0x0; /* also includes DOS */
        const PHP_STREAM_FLAG_DETECT_EOL          = 0x4;
        const PHP_STREAM_FLAG_EOL_MAC             = 0x8;

        /** coerce the stream into some other form */
        /** cast as a stdio FILE * */
        const PHP_STREAM_AS_STDIO   = 0;
        /** cast as a POSIX fd or socketd */
        const PHP_STREAM_AS_FD      = 1;
        /** cast as a socketd */
        const PHP_STREAM_AS_SOCKETD = 2;
        /** cast as fd/socket for select purposes */
        const PHP_STREAM_AS_FD_FOR_SELECT = 3;

        /** try really, really hard to make sure the cast happens (avoid using this flag if possible) */
        const PHP_STREAM_CAST_TRY_HARD  = 0x80000000;
        /** stream becomes invalid on success */
        const PHP_STREAM_CAST_RELEASE   = 0x40000000;
        /** stream cast for internal use */
        const PHP_STREAM_CAST_INTERNAL  = 0x20000000;
        const PHP_STREAM_CAST_MASK = (self::PHP_STREAM_CAST_TRY_HARD | self::PHP_STREAM_CAST_RELEASE | self::PHP_STREAM_CAST_INTERNAL);

        /* change the blocking mode of stream: value == 1 => blocking, value == 0 => non-blocking. */
        const PHP_STREAM_OPTION_BLOCKING        = 1;

        /** change the buffering mode of stream.
         * value is a PHP_STREAM_BUFFER_XXXX value, ptrparam is a ptr to a size_t holding
         * the required buffer size */
        const PHP_STREAM_OPTION_READ_BUFFER     = 2;
        const PHP_STREAM_OPTION_WRITE_BUFFER    = 3;
        /** unbuffered */
        const PHP_STREAM_BUFFER_NONE    = 0;
        /** line buffered */
        const PHP_STREAM_BUFFER_LINE    = 1;
        /** fully buffered */
        const PHP_STREAM_BUFFER_FULL    = 2;

        /** set the timeout duration for reads on the stream. ptrparam is a pointer to a struct timeval */
        const PHP_STREAM_OPTION_READ_TIMEOUT    = 4;
        const PHP_STREAM_OPTION_SET_CHUNK_SIZE  = 5;

        /** set or release lock on a stream */
        const PHP_STREAM_OPTION_LOCKING         = 6;

        /** whether or not locking is supported */
        const PHP_STREAM_LOCK_SUPPORTED         = 1;

        protected $isZval = false;
        protected $fd = [];
        protected ?int $file = null;
        protected ?object $gc_object = null;

        /** @var Resource|PhpStream */
        protected static $instances = null;

        public function __destruct()
        {
            $this->free();
        }

        protected function __construct(string $typedef, bool $create = true)
        {
            $this->isZval = false;
            if ($create) {
                $this->ze_other = \ze_ffi()->new($typedef);
                $this->ze_other_ptr = \ffi_ptr($this->ze_other);
            }
        }

        public function free(): void
        {
            if (!\is_null($this->ze_other_ptr)) {
                if (\is_typeof($this->ze_other_ptr, 'struct _php_stream*'))
                    \ze_ffi()->_php_stream_free($this->ze_other_ptr, self::PHP_STREAM_FREE_CLOSE);
                else
                    \ffi_free_if($this->ze_other_ptr);

                $this->ze_other_ptr = null;
                $this->ze_other = null;
            }
        }

        /** @return int|CData */
        public function __invoke($isZval = true)
        {
            return $this->ze_other_ptr;
        }

        public function fd(): int
        {
            return $this->fd[$this->file][0];
        }

        public function clear(int $handle): void
        {
            if (isset($this->fd[$handle])) {
                [$fd, $res] = $this->fd[$handle];
                unset($this->fd[$fd], $this->fd[(int)$res]);

                static::$instances[$fd] = null;
                $resource = static::$instances[(int)$res];
                static::$instances[(int)$res] = null;

                if (\count($this->fd) === 0) {
                    \zval_del_ref($resource);
                    if (!\is_null($this->gc_object)) {
                        $object = $this->gc_object;
                        $this->gc_object = null;
                        \zval_del_ref($object);
                    }
                }
            }
        }

        public function add_object(object $store): self
        {
            $this->gc_object = $store;

            return $this;
        }

        /**
         * @param integer $fd0
         * @param resource|Zval $resource0
         * @param integer|null $fd1
         * @param resource|Zval $resource1
         * @return self
         */
        public function add_fd_pair(int $fd0, $resource0, int $fd1 = null, $resource1 = null): self
        {
            if (!$resource0 instanceof Zval && !\is_resource($resource0))
                return \ze_ffi()->zend_error(\E_WARNING, "invalid resource passed");

            /** @var resource */
            $fd = $resource0 instanceof Zval
                ? \zval_native($resource0)
                : $resource0;

            $this->file = $fd0;
            $this->fd[$fd0] = [$fd0, $fd];
            $this->fd[(int)$fd] = [$fd0, $fd];
            static::$instances[$fd0] = $this;
            static::$instances[(int)$fd] = $this;
            if (!\is_null($fd1) && !\is_null($resource1)) {
                if (!$resource1 instanceof Zval && !\is_resource($resource1))
                    return \ze_ffi()->zend_error(\E_WARNING, "invalid resource passed");

                /** @var resource */
                $resource = $resource1 instanceof Zval
                    ? \zval_native($resource1)
                    : $resource1;

                $this->fd[$fd1] = [$fd1, $resource];
                $this->fd[(int)$resource] = [$fd1, $resource];
                static::$instances[$fd1] = $this;
                static::$instances[(int)$resource] = $this;
            }

            return $this;
        }

        public function get_pair(int $fd): ?array
        {
            return $this->fd[$fd] ?? null;
        }

        public static function is_valid(int $fd): bool
        {
            return isset(static::$instances[$fd]) && static::$instances[$fd] instanceof static;
        }

        /**
         * @param integer $handle
         * @param boolean $get_Int file descriptor
         * @param boolean $getSelf
         * @param boolean $getPair
         * @return self|int|array|CData|null
         */
        public static function get_fd(int $handle, bool $get_Int = true, bool $getPair = false, bool $getSelf = false)
        {
            $resource = null;
            if (static::is_valid($handle)) {
                /** @var Resource|PhpStream|CData */
                $resource = static::$instances[$handle];
                if ($getSelf)
                    return $resource;
                elseif ($getPair)
                    return $resource->get_pair($handle);
                elseif ($get_Int)
                    return $resource->fd();

                return $resource();
            }

            return $resource;
        }

        public static function remove_fd(int $handle): void
        {
            if (isset(static::$instances[$handle])) {
                /** @var Resource|PhpStream */
                $object = static::$instances[$handle];
                $object->clear($handle);
            }
        }

        public static function init(string $type = 'php_socket_t', bool $create = true): self
        {
            return new static($type, $create);
        }
    }
}
