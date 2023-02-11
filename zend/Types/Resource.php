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
        protected ?int $index = null;
        protected ?object $extra = null;
        protected ?Zval $zval = null;

        /** @var Resource|PhpStream */
        protected static $instances = null;

        public function __destruct()
        {
            if (!\is_null($this->extra)) {
                $this->extra = null;
            }

            $this->free();
        }

        public function free(): void
        {
            if (!\is_null($this->ze_other_ptr) && \count($this->fd) === 0) {
                if (\is_typeof($this->ze_other_ptr, 'struct _php_stream*'))
                    \ze_ffi()->_php_stream_free($this->ze_other_ptr, self::PHP_STREAM_FREE_CLOSE | self::PHP_STREAM_FREE_CLOSE_CASTED);
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
            return $this->index;
        }

        public function clear(int $handle): void
        {
            if (!\is_null($this->fd) && isset($this->fd[$handle])) {
                [$fd, $res] = $this->fd[$handle];
                unset($this->fd[$fd], $this->fd[$res]);
                static::$instances[$fd] = static::$instances[$res] = null;
            }

            if (\count($this->fd) === 0) {
                $this->zval = null;
                $this->index = null;
            }
        }

        public function get_zval(): ?Zval
        {
            return $this->zval;
        }

        public function add_object(object $extra): self
        {
            $this->extra = $extra;

            return $this;
        }

        public function add_pair(Zval $zval, int $fd1, int $resource1, int $fd0 = null, int $resource0 = null)
        {
            $this->zval = $zval;
            $this->index = $fd1;
            $this->fd[$fd1] = $this->fd[$resource1] = [$fd1, $resource1];
            static::$instances[$fd1] = static::$instances[$resource1] = $this;
            if (!\is_null($fd0) && !\is_null($resource0)) {
                $this->fd[$fd0] = $this->fd[$resource0] = [$fd0, $resource0];
                static::$instances[$fd0] = static::$instances[$resource0] = $this;
            }

            return $this;
        }

        public function get_pair(int $fd): ?int
        {
            return $this->fd[$fd][0] ?? null;
        }

        public static function is_valid(int $fd): bool
        {
            return isset(static::$instances[$fd]) && static::$instances[$fd] instanceof static;
        }

        /**
         * @param integer $handle
         * @param boolean $getZval
         * @param boolean $getPair
         * @param boolean $getInt file descriptor
         * @return Zval|int|CData|null
         */
        public static function get_fd(int $handle, bool $getZval = false, bool $getPair = false, bool $getInt = false)
        {
            if (static::is_valid($handle)) {
                /** @var Resource|PhpStream */
                $resource = static::$instances[$handle];
                if ($getZval)
                    return $resource->get_zval();
                elseif ($getPair)
                    return $resource->get_pair($handle);
                elseif ($getInt)
                    return $resource->fd();
                else
                    return $resource();
            }

            return null;
        }

        public static function remove_fd(int $handle): void
        {
            if (static::is_valid($handle)) {
                /** @var Resource|PhpStream */
                $object = static::$instances[$handle];
                $object->clear($handle);
            }
        }

        public static function init(string $type = 'uv_file'): self
        {
            return new static($type, false);
        }
    }
}
