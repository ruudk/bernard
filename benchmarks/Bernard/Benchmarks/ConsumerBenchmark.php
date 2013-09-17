<?php

namespace Bernard\Benchmarks;

use Bernard\Message\DefaultMessage;
use Bernard\Envelope;
use Bernard\QueueFactory\InMemoryFactory;
use Bernard\Consumer;
use Bernard\ServiceResolver\ObjectResolver;
use Bernard\Middleware\MiddlewareBuilder;
use Bernard\Tests\Fixtures;

class ConsumerBenchmark extends \Athletic\AthleticEvent
{
    public function setUp()
    {
        $services = new ObjectResolver;
        $services->register('SendNewsletter', new Fixtures\Service);

        $this->queues = new InMemoryFactory();

        // Create a lot of messages.
        for ($i = 0;$i < 100000;$i++) {
            $this->queues->create('send-newsletter')->enqueue(
                new Envelope(new DefaultMessage('SendNewsletter'))
            );
        }

        $this->consumer = new Consumer($services, new MiddlewareBuilder);
    }

    /**
     * @iterations 100000
     */
    public function consume()
    {
        $this->consumer->tick($this->queues->create('send-newsletter'));
    }
}
