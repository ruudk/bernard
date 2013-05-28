<?php

namespace Bernard\ServiceResolver;

use Bernard\Message;

/**
 * @package Bernard
 */
class ObjectResolver extends AbstractResolver
{
    protected $services = array();

    /**
     * {@inheritDoc}
     */
    public function register($name, $service)
    {
        if (!is_object($service)) {
            throw new \InvalidArgumentException('The given service is not an object.');
        }

        parent::register($name, $service);
    }

    /**
     * {@inheritDoc}
     */
    protected function getService(Message $message)
    {
        return $this->services[$message->getName()];
    }
}
