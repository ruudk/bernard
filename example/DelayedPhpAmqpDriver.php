<?php

use Bernard\Driver\PhpAmqpDriver;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;

class DelayedPhpAmqpDriver extends PhpAmqpDriver
{
    public function createQueue($queueName)
    {
        $this->channel->exchange_declare(
            $this->exchange,
            'x-delayed-message', // Custom
            false,
            true,
            false,
            false,
            false,
            new AMQPTable(array('x-delayed-type' => 'direct')) // Custom
        );
        $this->channel->queue_declare($queueName, false, true, false, false);
        $this->channel->queue_bind($queueName, $this->exchange);
    }

    public function pushMessage($queueName, $message, $delay = null)
    {
        $amqpMessage = new AMQPMessage($message, $this->defaultMessageParams);

        // Delay this message for 10 seconds
        $amqpMessage->set('application_headers', new AMQPTable(array("x-delay" => 10000)));

        $this->channel->basic_publish($amqpMessage, $this->exchange);
    }
}
