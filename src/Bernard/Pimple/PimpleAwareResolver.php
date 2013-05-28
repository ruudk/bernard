<?php

namespace Bernard\Pimple;

use Pimple;
use Bernard\Message;

/**
 * @package Bernard
 */
class PimpleAwareResolver extends \Bernard\ServiceResolver\AbstractResolver
{
    protected $container;

    /**
     * @param Pimple $container
     */
    public function __construct(Pimple $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    protected function getService(Message $message)
    {
        return $this->container[$this->services[$message->getName()]];
    }
}
