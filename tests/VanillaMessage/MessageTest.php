<?php

namespace Rentalhost\VanillaMessage;

use PHPUnit_Framework_TestCase;

class MessageTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test basic methods.
     * @covers Rentalhost\VanillaMessage\Message::__construct
     * @covers Rentalhost\VanillaMessage\Message::push
     * @covers Rentalhost\VanillaMessage\Message::count
     * @covers Rentalhost\VanillaMessage\Message::countType
     * @covers Rentalhost\VanillaMessage\Message::has
     * @covers Rentalhost\VanillaMessage\Message::hasType
     * @covers Rentalhost\VanillaMessage\Message::getArray
     */
    public function testBasic()
    {
        $messages = new Message;

        $this->assertSame([], $messages->getArray());
        $this->assertSame(0, $messages->count());
        $this->assertFalse($messages->has());

        $messages->push("hello");

        $this->assertSame(1, $messages->count());
        $this->assertSame(1, $messages->countType(null));
        $this->assertSame(0, $messages->countType("other"));

        $this->assertTrue($messages->has());
        $this->assertTrue($messages->hasType(null));
        $this->assertFalse($messages->hasType("other"));
    }

    /**
     * Test getOnly method.
     * @covers Rentalhost\VanillaMessage\Message::getOnly
     */
    public function testGetOnly()
    {
        $messages = new Message;
        $messages->push("error1", "error");
        $messages->push("error2", "error");
        $messages->push("success1", "success");
        $messages->push("success2", "success");
        $messages->push("error3", "error");

        $messagesCompare = new Message;
        $messagesCompare->push("error1", "error");
        $messagesCompare->push("error2", "error");
        $messagesCompare->push("error3", "error");

        $this->assertEquals($messagesCompare, $messages->getOnly("error"));
    }

    /**
     * Test types definition.
     */
    public function testTypes()
    {
        $messages = new Message;

        $this->assertFalse($messages->hasType(null));
        $this->assertFalse($messages->hasType("error"));
        $this->assertFalse($messages->hasType("warning"));
        $this->assertFalse($messages->hasType("success"));

        $messages->push("empty");

        $this->assertTrue($messages->hasType(null));
        $this->assertFalse($messages->hasType("error"));
        $this->assertFalse($messages->hasType("warning"));
        $this->assertFalse($messages->hasType("success"));

        $messages->push("error1", "error");
        $messages->push("error2", "error");

        $this->assertTrue($messages->hasType(null));
        $this->assertTrue($messages->hasType("error"));
        $this->assertFalse($messages->hasType("warning"));
        $this->assertFalse($messages->hasType("success"));

        $messages->push("warning1", "warning");
        $messages->push("warning2", "warning");
        $messages->push("warning3", "warning");

        $this->assertTrue($messages->hasType(null));
        $this->assertTrue($messages->hasType("error"));
        $this->assertTrue($messages->hasType("warning"));
        $this->assertFalse($messages->hasType("success"));

        $messages->push("success1", "success");
        $messages->push("success2", "success");
        $messages->push("success3", "success");
        $messages->push("success4", "success");

        $this->assertTrue($messages->hasType(null));
        $this->assertTrue($messages->hasType("error"));
        $this->assertTrue($messages->hasType("warning"));
        $this->assertTrue($messages->hasType("success"));

        $this->assertSame(10, $messages->count());
        $this->assertSame(1, $messages->countType(null));
        $this->assertSame(2, $messages->countType("error"));
        $this->assertSame(3, $messages->countType("warning"));
        $this->assertSame(4, $messages->countType("success"));
    }

    /**
     * Test mergeWith method.
     * @covers Rentalhost\VanillaMessage\Message::mergeWith
     */
    public function testMergeWith()
    {
        $messages1 = new Message;
        $messages1->push("hello");

        $messages2 = new Message;
        $messages2->push("world");

        $this->assertSame(1, $messages1->count());
        $this->assertSame(1, $messages1->countType(null));

        $messages1->mergeWith($messages2);

        $this->assertSame(2, $messages1->count());
        $this->assertSame(2, $messages1->countType(null));
    }

    /**
     * Test getIterator method.
     * @covers Rentalhost\VanillaMessage\Message::getIterator
     */
    public function testGetIterator()
    {
        $messages = new Message;
        $messages->push("hello");
        $messages->push("world");

        // Automatic.
        $result = [];

        foreach ($messages->getIterator() as $message) {
            $result[] = $message->message;
        }

        $this->assertSame([ "hello", "world" ], $result);

        // Manual.
        $messagesIterator = $messages->getIterator();
        $messageCurrent = $messagesIterator->current();

        $this->assertSame("hello", $messageCurrent->message);
        $this->assertSame(null, $messageCurrent->type);

        $messagesIterator->next();
        $messageCurrent = $messagesIterator->current();

        $this->assertSame("world", $messageCurrent->message);
        $this->assertSame(null, $messageCurrent->type);

        $messagesIterator->next();
        $messageCurrent = $messagesIterator->current();

        $this->assertNull($messageCurrent);
    }
}
