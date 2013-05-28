<?php

namespace spec\Bernard\ServiceResolver;

require_once __DIR__ . '/AbstractResolverSpec.php';

class ObjectResolverSpec extends AbstractResolverSpec
{
    function it_only_allow_objects_as_service()
    {
        $this->shouldThrow(new \InvalidArgumentException('The given service is not an object.'))
            ->duringRegister('ImportUsers', 'obviously not an object');

        $this->shouldNotThrow()
            ->duringRegister('ImportUsers', new \stdClass);
    }

    /**
     * @param Bernard\Message $message
     */
    function it_resolve_to_an_invocator($message, $container)
    {
        $this->register('ImportUsers', new \stdClass);

        parent::it_resolve_to_an_invocator($message, null);
    }
}
