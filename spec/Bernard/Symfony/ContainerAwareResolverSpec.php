<?php

namespace spec\Bernard\Symfony;

use Bernard\ServiceResolver\Invocator;

class ContainerAwareResolverSpec extends \PhpSpec\ObjectBehavior
{
    /**
     * @param Symfony\Component\DependencyInjection\Container $container
     */
    function let($container)
    {
        $this->beConstructedWith($container);
    }

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
        $this->register('ImportUsers', 'import_users_service');

        $message->getName()->shouldBeCalled()
            ->willReturn('ImportUsers');

        $container->get('import_users_service')->shouldBeCalled()
            ->willReturn(new \stdClass);

        $this->resolve($message)->shouldBeLike(new Invocator(new \stdClass, $message->getWrappedObject()));
    }
}
