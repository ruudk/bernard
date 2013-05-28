<?php

namespace spec\Bernard\Symfony;

use Bernard\Message\DefaultMessage;

class DefaultMessageNormalizerSpec extends \PhpSpec\ObjectBehavior
{
    function it_implements_normalizer_and_denormalizer()
    {
        $this->shouldBeAnInstanceOf('Symfony\Component\Serializer\Normalizer\NormalizerInterface');
        $this->shouldBeAnInstanceOf('Symfony\Component\Serializer\Normalizer\DenormalizerInterface');
    }

    function it_supports_normalization_and_denormalization_of_default_messages()
    {
        $this->supportsNormalization(new \stdClass)->shouldReturn(false);
        $this->supportsNormalization(new DefaultMessage('ImportUsers'))->shouldReturn(true);

        $this->supportsDenormalization(array(), 'stdClass')->shouldReturn(false);
        $this->supportsDenormalization(array(), 'Bernard\Message\DefaultMessage')->shouldReturn(true);
    }

    function it_normalizes_a_default_message()
    {
        $this->normalize(new DefaultMessage('ImportUsers'))
            ->shouldReturn(array('name' => 'ImportUsers'));

        $this->normalize(new DefaultMessage('ImportUsers', array('role' => 'ROLE_SUPER_ADMIN')))
            ->shouldReturn(array('name' => 'ImportUsers', 'role' => 'ROLE_SUPER_ADMIN'));
    }

    function it_denormalizes_a_default_message()
    {
        $this->denormalize(array('name' => 'ImportUsers'), 'Bernard\Message\DefaultMessage')
            ->shouldBeLike(new DefaultMessage('ImportUsers'));

        $this->denormalize(array('name' => 'ImportUsers', 'role' => 'ROLE_SUPER_ADMIN'), 'Bernard\Message\DefaultMessage')
            ->shouldBeLike(new DefaultMessage('ImportUsers', array('role' => 'ROLE_SUPER_ADMIN')));
    }
}
