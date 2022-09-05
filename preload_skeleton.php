<?php

declare(strict_types=1);

if (!\function_exists('tag_changeMe_preload')) {
  /**
   * Check for _active_ `tag_changeMe` **ffi** instance
   *
   * @return boolean
   */
  function is_tag_changeMe_ffi(): bool
  {
    return Core::get('tag_changeMe') instanceof \FFI;
  }

  function tag_changeMe_ffi(): \FFI
  {
    return Core::get('tag_changeMe');
  }

  function tag_changeMe_init(): void
  {
    if (!\is_tag_changeMe_ffi()) {
      // Try if preloaded
      try {
        Core::set('tag_changeMe', \FFI::scope("_tag_changeMe_"));
      } catch (Exception $e) {
        \tag_changeMe_preload();
      }

      if (!\is_tag_changeMe_ffi()) {
        throw new \RuntimeException("FFI parse failed!");
      }
    }
  }

  function tag_changeMe_preload(): void
  {
    \setup_ffi_loader('tag_changeMe', 'filepath_to_headers');
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
  }

  \tag_changeMe_preload();
}
