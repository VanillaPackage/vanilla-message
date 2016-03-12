<?php

namespace Rentalhost\VanillaMessage\Mock;

use Rentalhost\VanillaMessage\Message as MessageBase;

/**
 * Class Message
 * @package Rentalhost\VanillaMessage\Mock
 */
class Message extends MessageBase
{
    /**
     * Return a new instance of MessageItem (mocked).
     */
    /** @noinspection PhpMissingParentCallCommonInspection */
    protected function newMessageItem()
    {
        return new MessageItem($this);
    }
}
