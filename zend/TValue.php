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
      \ze_ffi()->tsrm_mutex_lock($mutex);
      $this->result = $result;
      \ze_ffi()->tsrm_mutex_unlock($mutex);
    }
  }
}
