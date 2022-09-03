<?php

declare(strict_types=1);

namespace Tests;

class Dummy
{
    const SOME_CONST = 123;

    public int $property = 42;

    private int $secret = 100500;

    /**
     * This method will be removed during the test, do not call it or use it
     */
    private function methodToRemove(): void
    {
        die('Method should not be called and must be removed');
    }

    public function method(): ?string
    {
        // If we make this method static in runtime, then $this won't be passed to it
        return isset($this) ? get_class($this) : null;
    }

    public function setSecret(int $newSecret): void
    {
        $this->secret = $newSecret;
    }

    public function tellSecret(): int
    {
        return $this->secret;
    }
}
