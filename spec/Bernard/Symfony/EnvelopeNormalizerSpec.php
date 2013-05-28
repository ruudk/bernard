<?php

namespace spec\Bernard\Symfony;

use Bernard\Message\DefaultMessage;
use Bernard\Message\Envelope;

class EnvelopeNormalizerSpec extends \PhpSpec\ObjectBehavior
{
    /**
     * @param Symfony\Component\Serializer\Serializer $serializer
     */
    function let($serializer)
    {
        $this->setSerializer($serializer);
    }

    function it_implements_normalizer_and_denormalizer()
    {
        $this->shouldBeAnInstanceOf('Symfony\Component\Serializer\Normalizer\NormalizerInterface');
        $this->shouldBeAnInstanceOf('Symfony\Component\Serializer\Normalizer\DenormalizerInterface');
        $this->shouldBeAnInstanceOf('Symfony\Component\Serializer\Normalizer\SerializerAwareNormalizer');
    }

    function it_supports_normalizing_denormalizing_envelopes()
    {
        $this->supportsNormalization(new \stdClass)->shouldReturn(false);
        $this->supportsNormalization(new Envelope(new DefaultMessage('ImportUsers')))->shouldReturn(true);

        $this->supportsDenormalization(null, 'stdClass')->shouldReturn(false);
        $this->supportsDenormalization(null, 'Bernard\Message\Envelope')->shouldReturn(true);
    }

    function it_normalizes_a_envelope_with_default_message_and_normalizes_class($serializer)
    {
        $envelope = new Envelope(new DefaultMessage('ImportUsers'));

        $serializer->normalize($envelope->getMessage(), null, array())->willReturn(array());

        $this->normalize($envelope)->shouldReturn(array(
            'args'      => array(),
            'class'     => 'Bernard:Message:DefaultMessage',
            'timestamp' => $envelope->getTimestamp(),
            'retries'   => 0,
        ));
    }

    function it_denormalizes_a_envelope($serializer)
    {
        $serializer->denormalize(array('name' => 'ImportUsers'), 'Bernard\Message\DefaultMessage', null, array())
            ->shouldBeCalled()->willReturn(new DefaultMessage('ImportUsers'));

        $data = array('args' => array('name' => 'ImportUsers'), 'class' => 'Bernard:Message:DefaultMessage',
            'retries' => 0, 'timestamp' => time());

        $this->denormalize($data, 'Bernard\Message\Envelope')
            ->shouldBeLike(new Envelope(new DefaultMessage('ImportUsers')));
    }

    function it_denormalize_envelope_message_to_default_message_if_data_class_is_invalid($serializer)
    {
        $serializer->denormalize(array('name' => 'ImportUsers'), 'Bernard\Message\DefaultMessage', null, array())
            ->shouldBeCalled()->willReturn(new DefaultMessage('ImportUsers'));

        $data = array('args' => array('name' => 'ImportUsers'), 'class' => 'Invalid:Namespace:ImportUsers',
            'retries' => 0, 'timestamp' => time());

        // Envelope class should be the same class even when it does not exists.
        $envelope = new Envelope(new DefaultMessage('ImportUsers'));

        $refl = new \ReflectionProperty($envelope, 'class');
        $refl->setAccessible(true);
        $refl->setValue($envelope, 'Invalid\Namespace\ImportUsers');

        $this->denormalize($data, 'Bernard\Message\Envelope')->shouldBeLike($envelope);
    }
}
