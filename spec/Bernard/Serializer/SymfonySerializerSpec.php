<?php

namespace spec\Bernard\Serializer;

use Bernard\Message\Envelope;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SymfonySerializerSpec extends ObjectBehavior
{
    /**
     * @param Symfony\Component\Serializer\SerializerInterface $serializer
     * @param Bernard\Message $message
     */
    function let($serializer)
    {
        $this->beConstructedWith($serializer);
    }

    function its_a_serializer()
    {
        $this->shouldBeAnInstanceOf('Bernard\Serializer');
    }

    function it_serializes_into_json($serializer, $message)
    {
        $envelope = new Envelope($message->getWrappedObject());

        $serializer->serialize($envelope, 'json')
            ->shouldBeCalled()->willReturn('json encoded');

        $this->serialize($envelope)->shouldReturn('json encoded');
    }

    function it_deserializes_json_into_envelope($serializer, $message)
    {
        $envelope = new Envelope($message->getWrappedObject());

        $serializer->deserialize('json encoded', 'Bernard\Message\Envelope', 'json')
            ->shouldBeCalled()->willReturn($envelope);


        $this->deserialize('json encoded')->shouldReturn($envelope);
    }
}
