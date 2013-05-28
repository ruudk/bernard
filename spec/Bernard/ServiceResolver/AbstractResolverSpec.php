<?php

namespace spec\Bernard\ServiceResolver;

use Bernard\ServiceResolver\Invocator;

abstract class AbstractResolverSpec extends \PhpSpec\ObjectBehavior
{
    function its_a_service_resolver()
    {
        $this->shouldBeAnInstanceOf('Bernard\ServiceResolver');
    }

    /**
     * @param Bernard\Message $message
     */
    function it_throws_an_exception_when_message_name_is_unknown($message)
    {
        $message->getName()->shouldBeCalled()
            ->willReturn('ImportUsers');

        $this->shouldThrow(new \InvalidArgumentException('No service registered for message "ImportUsers".'))
            ->duringResolve($message);
    }

    /**
     * @param Bernard\Message $message
     */
    function it_resolve_to_an_invocator($message, $container)
    {
        $message->getName()->shouldBeCalled()
            ->willReturn('ImportUsers');

        $this->resolve($message)->shouldBeLike(new Invocator(new \stdClass, $message->getWrappedObject()));
    }
}
