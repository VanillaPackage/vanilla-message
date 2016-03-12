<?php

namespace Rentalhost\VanillaMessage;

use PHPUnit_Framework_TestCase;

/**
 * Class MessageTest
 * @package Rentalhost\VanillaMessage
 */
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

        static::assertSame([ ], $messages->getArray());
        static::assertSame(0, $messages->count());
        static::assertFalse($messages->has());

        $messages->push('hello');

        static::assertSame(1, $messages->count());
        static::assertSame(1, $messages->countType(null));
        static::assertSame(0, $messages->countType('other'));

        static::assertTrue($messages->has());
        static::assertTrue($messages->hasType(null));
        static::assertFalse($messages->hasType('other'));
    }

    /**
     * Test getIterator method.
     * @covers Rentalhost\VanillaMessage\Message::getIterator
     */
    public function testGetIterator()
    {
        $messages = new Message;
        $messages->push('hello');
        $messages->push('world');

        // Automatic.
        $result = [ ];

        foreach ($messages->getIterator() as $message) {
            $result[] = $message->message;
        }

        static::assertSame([ 'hello', 'world' ], $result);

        // Manual.
        $messagesIterator = $messages->getIterator();
        $messageCurrent   = $messagesIterator->current();

        static::assertSame('hello', $messageCurrent->message);
        static::assertNull($messageCurrent->type);

        $messagesIterator->next();
        $messageCurrent = $messagesIterator->current();

        static::assertSame('world', $messageCurrent->message);
        static::assertNull($messageCurrent->type);

        $messagesIterator->next();
        $messageCurrent = $messagesIterator->current();

        static::assertNull($messageCurrent);
    }

    /**
     * Test getOnly method.
     * @covers Rentalhost\VanillaMessage\Message::getOnly
     */
    public function testGetOnly()
    {
        $messages = new Message;
        $messages->push('error1', 'error');
        $messages->push('error2', 'error');
        $messages->push('success1', 'success');
        $messages->push('success2', 'success');
        $messages->push('error3', 'error');

        $messagesCompare = new Message;
        $messagesCompare->push('error1', 'error');
        $messagesCompare->push('error2', 'error');
        $messagesCompare->push('error3', 'error');

        static::assertEquals($messagesCompare, $messages->getOnly('error'));
    }

    /**
     * Test mergeWith method.
     * @covers Rentalhost\VanillaMessage\Message::mergeWith
     */
    public function testMergeWith()
    {
        $messages1 = new Message;
        $messages1->push('hello');

        $messages2 = new Message;
        $messages2->push('world');

        static::assertSame(1, $messages1->count());
        static::assertSame(1, $messages1->countType(null));

        $messages1->mergeWith($messages2);

        static::assertSame(2, $messages1->count());
        static::assertSame(2, $messages1->countType(null));
    }

    /**
     * Test types definition.
     * @coversNothing
     */
    public function testPushWithData()
    {
        $messages = new Message;
        $messages->push(null, null, true);

        foreach ($messages->getIterator() as $message) {
            static::assertTrue($message->data);
        }
    }

    /**
     * Test types definition.
     * @coversNothing
     */
    public function testTypes()
    {
        $messages = new Message;

        static::assertFalse($messages->hasType(null));
        static::assertFalse($messages->hasType('error'));
        static::assertFalse($messages->hasType('warning'));
        static::assertFalse($messages->hasType('success'));

        $messages->push('empty');

        static::assertTrue($messages->hasType(null));
        static::assertFalse($messages->hasType('error'));
        static::assertFalse($messages->hasType('warning'));
        static::assertFalse($messages->hasType('success'));

        $messages->push('error1', 'error');
        $messages->push('error2', 'error');

        static::assertTrue($messages->hasType(null));
        static::assertTrue($messages->hasType('error'));
        static::assertFalse($messages->hasType('warning'));
        static::assertFalse($messages->hasType('success'));

        $messages->push('warning1', 'warning');
        $messages->push('warning2', 'warning');
        $messages->push('warning3', 'warning');

        static::assertTrue($messages->hasType(null));
        static::assertTrue($messages->hasType('error'));
        static::assertTrue($messages->hasType('warning'));
        static::assertFalse($messages->hasType('success'));

        $messages->push('success1', 'success');
        $messages->push('success2', 'success');
        $messages->push('success3', 'success');
        $messages->push('success4', 'success');

        static::assertTrue($messages->hasType(null));
        static::assertTrue($messages->hasType('error'));
        static::assertTrue($messages->hasType('warning'));
        static::assertTrue($messages->hasType('success'));

        static::assertSame(10, $messages->count());
        static::assertSame(1, $messages->countType(null));
        static::assertSame(2, $messages->countType('error'));
        static::assertSame(3, $messages->countType('warning'));
        static::assertSame(4, $messages->countType('success'));
    }
}
