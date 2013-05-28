<?php

namespace spec\Bernard\Pimple;

require_once __DIR__ . '/../ServiceResolver/AbstractResolverSpec.php';

class PimpleAwareResolverSpec extends \spec\Bernard\ServiceResolver\AbstractResolverSpec
{
    /**
     * @param Pimple $container
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
        $container->offsetGet('import_users_service')->shouldBeCalled()
            ->willReturn(new \stdClass);

        parent::it_resolve_to_an_invocator($message, $container);
    }
}
