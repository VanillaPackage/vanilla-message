<?php

namespace Rentalhost\VanillaMessage;

/**
 * Class MessageItem
 * @package Rentalhost\VanillaMessage
 */
class MessageItem
{
    /**
     * Stores message text.
     * @var string
     */
    public $message;

    /**
     * Stores message type.
     * @var string
     */
    public $type;

    /**
     * Stores some kind of additional data.
     * @var mixed
     */
    public $data;
}
