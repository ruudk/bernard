<?php

namespace spec\Bernard\Queue;

use Bernard\Exception\InvalidOperationException;
use Bernard\Message\DefaultMessage;
use Bernard\Message\Envelope;

class PersistentQueueSpec extends \PhpSpec\ObjectBehavior
{
    /**
     * @param Bernard\Driver $driver
     * @param Bernard\Serializer $serializer
     */
    function let($driver, $serializer)
    {
        $this->beConstructedWith('my-queue', $driver, $serializer);
    }

    function its_a_queue()
    {
        $this->shouldBeAnInstanceOf('Bernard\Queue');
    }

    function it_count_messages($driver)
    {
        $driver->createQueue('my-queue')->shouldBeCalled();
        $driver->countMessages('my-queue')->shouldBeCalled()->willReturn(5);

        $this->count()->shouldReturn(5);
    }

    function it_serializes_envelope_when_enqueuing_messsage($driver, $serializer)
    {
        $envelope = new Envelope(new DefaultMessage('ImportUsers'));

        $serializer->serialize($envelope)->shouldBeCalled()->willReturn('serialized-message');

        $driver->createQueue('my-queue')->shouldBeCalled();
        $driver->pushMessage('my-queue', 'serialized-message')->shouldBeCalled();

        $this->enqueue($envelope);
    }

    function it_removes_queue_from_driver_when_closed($driver)
    {
        $driver->removeQueue('my-queue');

        $this->close();
    }

    function it_throws_exception_when_closed()
    {
        $exception = new InvalidOperationException('Queue "my-queue" is closed.');

        $this->close();

        $this->shouldThrow($exception)->duringCount();
        $this->shouldThrow($exception)->duringDequeue();
        $this->shouldThrow($exception)->duringEnqueue(new Envelope(new DefaultMessage('ImportUsers')));
        $this->shouldThrow($exception)->duringPeek();
    }
}
