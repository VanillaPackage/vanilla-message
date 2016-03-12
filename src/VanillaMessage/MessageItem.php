<?php

namespace Rentalhost\VanillaMessage;

/**
 * Class MessageItem
 * @package Rentalhost\VanillaMessage
 */
class MessageItem
{
    /**
     * Stores MessageItem parent.
     * @var Message
     */
    public $parent;

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
