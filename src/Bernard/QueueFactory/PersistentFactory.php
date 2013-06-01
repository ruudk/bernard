<?php

namespace Bernard\QueueFactory;

use Bernard\Driver;
use Bernard\Queue\PersistentQueue;
use Bernard\Serializer;

/**
 * Knows how to create queues and retrieve them from the used connection.
 * Every queue it creates is saved locally.
 *
 * @package Bernard
 */
class PersistentFactory implements \Bernard\QueueFactory
{
    protected $connection;
    protected $serializer;
    protected $queues = array();

    /**
     * @param Driver          $connection
     * @param SerializerInterface $serializer
     */
    public function __construct(Driver $connection, Serializer $serializer)
    {
        $this->connection = $connection;
        $this->serializer = $serializer;
    }

    /**
     * @param  string $queueName
     * @return Queue
     */
    public function create($queueName)
    {
        if (isset($this->queues[$queueName])) {
            return $this->queues[$queueName];
        }

        $queue = new PersistentQueue($queueName, $this->connection, $this->serializer);

        return $this->queues[$queueName] = $queue;
    }

    /**
     * @return Queue[]
     */
    public function all()
    {
        // Calls $this->create on every name returned from the connection
        array_map(array($this, 'create'), $this->connection->listQueues());

        return $this->queues;
    }

    /**
     * @param  string  $queueName
     * @return boolean
     */
    public function exists($queueName)
    {
        return isset($this->queues[$queueName]) ?: in_array($queueName, $this->connection->listQueues());
    }

    /**
     * @return integer
     */
    public function count()
    {
        return count($this->connection->listQueues());
    }

    /**
     * @param string $queueName
     */
    public function remove($queueName)
    {
        if (!$this->exists($queueName)) {
            return;
        }

        $this->create($queueName)->close();

        unset($this->queues[$queueName]);
    }
}
