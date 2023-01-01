<?php


declare(strict_types=1);

namespace ZE\Hook;

use FFI\CData;
use ZE\ZendString;
use ZE\ObjectHandler;
use ZE\Zval;

/**
 * Abstract object property operational hook
 */
abstract class AbstractProperty extends ObjectHandler
{
    /**
     * Member name
     */
    protected CData $member;

    /**
     * Internal cache slot (for native callback only)
     */
    protected ?CData $cacheSlot;

    /**
     * Returns a member name
     */
    public function member_name(): string
    {
        if (\IS_PHP74)
            Zval::init_value($this->member)->native_value($memberName);
        else
            $memberName = ZendString::init_value($this->member)->value();

        return $memberName;
    }
}
