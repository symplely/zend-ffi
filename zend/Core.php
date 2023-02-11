<?php

declare(strict_types=1);

use FFI\CData;
use FFI\CType;
use ZE\PhpStream;

if (!\class_exists('Core')) {
	final class Core
	{
		/** @var \FFI[] */
		private static $ffi = [];

		/** @var \MUTEX_T */
		private static ?CData $global_mutex = null;

		private static ?PhpStream $stream_stdout = null;
		private static ?PhpStream $stream_stderr = null;
		private static ?PhpStream $stream_stdin = null;

		private static bool $is_scoped = false;

		public function __destruct()
		{
			static::clear_mutex();
			static::clear_ffi();
		}

		private function __construct()
		{
		}

		public static function setup_stdio()
		{
			self::$stream_stdout = \php_stream_direct(1);
			self::$stream_stderr = \php_stream_direct(2);
			self::$stream_stdin = \php_stream_direct(0);
		}

		public static function clear_stdio(): void
		{
			self::$stream_stdout = null;
			self::$stream_stderr = null;
			self::$stream_stdin = null;
		}

		/**
		 * @param integer $fd
		 * @return PhpStream|null
		 */
		public static function get_stdio(int $fd): ?PhpStream
		{
			switch ($fd) {
				case 0:
					return self::$stream_stdin;
				case 1:
					return self::$stream_stdout;
				case 2:
					return self::$stream_stderr;
			}

			return null;
		}

		/**
		 * @return \MUTEX_T|null
		 */
		public static function get_mutex(): ?CData
		{
			return \PHP_ZTS ? self::$global_mutex : null;
		}

		/**
		 * @return \MUTEX_T
		 */
		public static function reset_mutex(): CData
		{
			if (\PHP_ZTS && \is_null(self::$global_mutex))
				self::$global_mutex = \ze_ffi()->tsrm_mutex_alloc();

			return self::$global_mutex;
		}

		public static function clear_mutex(): void
		{
			if (\PHP_ZTS && !\is_null(self::$global_mutex)) {
				\ze_ffi()->tsrm_mutex_free(self::$global_mutex);
				self::$global_mutex = null;
			}
		}

		public static function get(string $tag): ?\FFI
		{
			return self::$ffi[$tag] ?? null;
		}

		public static function set(string $tag, ?\FFI $ffi): void
		{
			self::$ffi[$tag] = $ffi;
		}

		public static function clear(string $tag): void
		{
			self::$ffi[$tag] = null;
		}

		public static function clear_ffi(): void
		{
			self::$ffi = null;
		}

		public static function cast(string $tag, $type, $ptr): ?CData
		{
			return self::$ffi[$tag]->cast($type, $ptr);
		}

		public static function struct(string $tag, $typedef, bool $owned = true, bool $persistent = false): ?CData
		{
			return self::$ffi[$tag]->new($typedef, $owned, $persistent);
		}

		public static function typedef(string $tag, string $typedef): ?CType
		{
			return self::$ffi[$tag]->type($typedef);
		}

		public static function scope_set(): void
		{
			self::$is_scoped = true;
		}

		public static function is_scoped(): bool
		{
			return self::$is_scoped;
		}
	}
}
