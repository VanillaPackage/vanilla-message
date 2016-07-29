<?php

namespace Rentalhost\VanillaMessage;

/**
 * Class MessageItem
 * @package Rentalhost\VanillaMessage
 */
class MessageItem
{
    /**
     * Stores some kind of additional data.
     * @var mixed
     */
    public $data;

    /**
     * Stores message text.
     * @var string
     */
    public $message;

    /**
     * Stores MessageItem parent.
     * @var Message
     */
    public $parent;

    /**
     * Stores message type.
     * @var string
     */
    public $type;

    /**
     * MessageItem constructor.
     *
     * @param Message $parent Message instance.
     */
    public function __construct(Message $parent)
    {
        $this->parent = $parent;
    }
}
