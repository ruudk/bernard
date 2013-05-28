<?php

namespace spec\Bernard\Serializer;

use Bernard\Message\Envelope;
use JMS\Serializer\SerializationContext;

class JMSSerializerSpec extends \PhpSpec\ObjectBehavior
{
    /**
     * @param JMS\Serializer\SerializerInterface $serializer
     * @param Bernard\Message $message
     */
    function let($serializer)
    {
        $this->beConstructedWith($serializer);
        $this->shouldBeAnInstanceOf('Bernard\Serializer');
    }

    function it_serializes_into_json_while_preserving_null($serializer, $message)
    {
        $envelope = new Envelope($message->getWrappedObject());
        $context = SerializationContext::create()
            ->setSerializeNull(true);

        $serializer->serialize($envelope, 'json', $context)
            ->shouldBeCalled()->willReturn('json encoded');

        $this->serialize($envelope)->shouldReturn('json encoded');
    }

    function it_deserializes_json_into_an_envelope_and_return($serializer, $message)
    {
        $envelope = new Envelope($message->getWrappedObject());
        $serializer->deserialize('json encoded', 'Bernard\Message\Envelope', 'json')
            ->shouldBeCalled()->willReturn($envelope);

        $this->deserialize('json encoded')->shouldReturn($envelope);
    }
}
