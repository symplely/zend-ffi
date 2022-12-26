<?php

declare(strict_types=1);

namespace ZE\Hook;

use ZE\Hook\CastObject;

/**
 * Allows to cast given object to scalar values, like integer, floats, etc
 */
interface CastInterface
{
    /**
     * Performs casting of given object to another value
     *
     * @param CastObject $hook Instance of current hook
     *
     * @return mixed Casted value
     */
    public static function __cast(CastObject $hook);
}
