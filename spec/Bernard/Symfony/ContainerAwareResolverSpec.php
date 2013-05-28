<?php

namespace spec\Bernard\Symfony;

require_once __DIR__ . '/../ServiceResolver/AbstractResolverSpec.php';

class ContainerAwareResolverSpec extends \spec\Bernard\ServiceResolver\AbstractResolverSpec
{
    /**
     * @param Symfony\Component\DependencyInjection\Container $container
     */
    function let($container)
    {
        $this->beConstructedWith($container);
    }

    /**
     * @param Bernard\Message $message
     */
    function it_resolve_to_an_invocator($message, $container)
    {
        $this->register('ImportUsers', 'import_users_service');

        $container->get('import_users_service')->shouldBeCalled()
            ->willReturn(new \stdClass);

        parent::it_resolve_to_an_invocator($message, $container);
    }
}
