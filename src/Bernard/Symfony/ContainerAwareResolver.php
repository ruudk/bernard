<?php

namespace Bernard\Symfony;

use Bernard\Message;
use Symfony\Component\DependencyInjection\Container;

/**
 * @package Bernard
 */
class ContainerAwareResolver extends \Bernard\ServiceResolver\AbstractResolver
{
    protected $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    protected function getService(Message $message)
    {
        return $this->container->get($this->services[$message->getName()]);
    }
}
