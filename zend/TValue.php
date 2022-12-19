<?php

declare(strict_types=1);

use FFI\CData;

if (\PHP_ZTS && !\class_exists('TValue')) {
  final class TValue
  {
    private $result = null;

    public function __destruct()
    {
      $this->result = null;
    }

    public function __invoke()
    {
      return $this->result;
    }

    public function set($result, CData $mutex): void
    {
      \ts_ffi()->pthread_mutex_lock($mutex);
      $this->result = $result;
      \ts_ffi()->pthread_mutex_unlock($mutex);
    }
  }
}
