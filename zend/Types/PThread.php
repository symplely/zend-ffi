<?php

declare(strict_types=1);

namespace ZE;

use ZE\Thread;

if (\PHP_ZTS && !\class_exists('PThread')) {
    final class PThread extends Thread
    {
    }
}
