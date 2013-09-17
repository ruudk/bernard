<?php

namespace Bernard\Benchmarks;

use Bernard\Producer;
use Bernard\Middleware\MiddlewareBuilder;
use Bernard\QueueFactory\InMemoryFactory;
use Bernard\Message\DefaultMessage;

class ProducerBenchmark extends \Athletic\AthleticEvent
{
    public function setUp()
    {
        $this->producer = new Producer(new InMemoryFactory(), new MiddlewareBuilder);
    }

    /**
     * @iterations 10000
     */
    public function produce()
    {
        $this->producer->produce(new DefaultMessage('ImportUsers'));
    }
}
