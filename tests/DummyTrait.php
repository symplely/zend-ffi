<?php

declare(strict_types=1);

namespace Tests;

trait DummyTrait
{
    public function foo($optionalArg = null)
    {
        return $optionalArg;
    }
}
