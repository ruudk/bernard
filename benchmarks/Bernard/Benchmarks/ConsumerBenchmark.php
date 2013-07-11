<?php

namespace Bernard\Benchmarks;

use Bernard\Message\DefaultMessage;
use Bernard\Message\Envelope;
use Bernard\QueueFactory\InMemoryFactory;
use Bernard\Consumer;
use Bernard\ServiceResolver\ObjectResolver;
use Bernard\Tests\Fixtures;

class ConsumerBenchmark extends \Athletic\AthleticEvent
{
    public function setUp()
    {
        $services = new ObjectResolver;
        $services->register('SendNewsletter', new Fixtures\Service);

        $this->queues = new InMemoryFactory();

        for ($i = 0;$i < 100000;$i++) {
            $this->queues->create('send-newsletter')->enqueue(
                new Envelope(new DefaultMessage('SendNewsletter'))
            );
        }

        $this->consumer = new Consumer($services);
    }

    /**
     * @iterations 100000
     */
    public function consume()
    {
        $this->consumer->tick($this->queues->create('send-newsletter'));
    }
}
