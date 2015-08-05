<?php

namespace Rentalhost\VanillaMessage;

use ArrayIterator;

class Message
{
    /**
     * Stores messages.
     * @var MessageItem[]
     */
    private $messages;

    /**
     * Construct a Message instance.
     */
    public function __construct()
    {
        $this->messages = [];
    }

    /**
     * Push a new message.
     * @param  string $message  Message.
     * @param  string $type     Type of message.
     */
    public function push($message, $type = null)
    {
        $messageItem = new MessageItem;
        $messageItem->message = $message;
        $messageItem->type = $type;

        $this->messages[] = $messageItem;
    }

    /**
     * Merge this message list with another list.
     * @param  self   $messageInstance Message instance.
     */
    public function mergeWith(self $messageInstance)
    {
        $this->messages = array_merge($this->messages, $messageInstance->messages);
    }

    /**
     * Count messages.
     * @return integer
     */
    public function count()
    {
        return count($this->messages);
    }

    /**
     * Count messages filtering by type.
     * @param  string $type Type to filter.
     * @return integer
     */
    public function countType($type)
    {
        $typeCount = 0;

        foreach ($this->messages as $messageItem) {
            if ($messageItem->type === $type) {
                $typeCount++;
            }
        }

        return $typeCount;
    }

    /**
     * Returns true if has some message.
     * @return boolean
     */
    public function has()
    {
        return !empty($this->messages);
    }

    /**
     * Return if a type was pushed.
     * @param  string  $type Type to check.
     * @return boolean
     */
    public function hasType($type)
    {
        foreach ($this->messages as $messageItem) {
            if ($messageItem->type === $type) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns a self with only the specified type.
     * @param  string $type Type.
     * @return self
     */
    public function getOnly($type)
    {
        $messages = new self;

        foreach ($this->messages as $message) {
            if ($message->type === $type) {
                $messages->messages[] = $message;
            }
        }

        return $messages;
    }

    /**
     * Returns all messages as an array.
     * @return MessageItem[]
     */
    public function getArray()
    {
        return $this->messages;
    }

    /**
     * Returns an array iterator over messages.
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->messages);
    }
}
