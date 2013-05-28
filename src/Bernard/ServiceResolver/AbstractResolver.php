<?php

namespace Bernard\ServiceResolver;

use Bernard\Message;

/**
 * Implements Abstracted Protected methods thas simplifies implementing
 * a custom ServiceResolver while keeping to its defined interface.
 *
 * @package Bernard
 */
abstract class AbstractResolver implements \Bernard\ServiceResolver
{
    protected $services;

    /**
     * {@inheritDoc}
     */
    public function register($name, $service)
    {
        $this->services[$name] = $service;
    }

    /**
     * {@inheritDoc}
     */
    public function resolve(Message $message)
    {
        if (!isset($this->services[$message->getName()])) {
            throw new \InvalidArgumentException('No service registered for message "' . $message->getName() . '".');
        }

        return new Invocator($this->getService($message), $message);
    }

    /**
     * @param Message $message
     * @return boolean
     */
    abstract protected function getService(Message $message);
}
