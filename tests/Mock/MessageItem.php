<?php

namespace Rentalhost\VanillaMessage\Mock;

use Rentalhost\VanillaMessage\MessageItem as MessageItemBase;

/**
 * Class MessageItem
 * @package Rentalhost\VanillaMessage\Mock
 */
class MessageItem extends MessageItemBase
{
    /**
     * Just return true.
     * @return true
     */
    public function mocked()
    {
        return true;
    }
}
