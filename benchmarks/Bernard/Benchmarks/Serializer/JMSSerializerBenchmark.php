<?php

namespace Bernard\Benchmarks\Serializer;

use Bernard\Message\DefaultMessage;
use Bernard\Message\Envelope;
use Bernard\Serializer\JMSSerializer;
use Bernard\JMSSerializer\EnvelopeHandler;
use JMS\Serializer\SerializerBuilder;


class JMSSerializerBenchmark extends \Athletic\AthleticEvent
{
    public function setUp()
    {
        $jmsSerializer = SerializerBuilder::create()
            ->configureHandlers(function ($registry) {
                $registry->registerSubscribingHandler(new EnvelopeHandler);
            })
            ->build()
        ;

        $this->serializer = new JMSSerializer($jmsSerializer);
    }

    /**
     * @iterations 10000
     */
    public function serialize()
    {
        $this->serializer->serialize(new Envelope(new DefaultMessage('ImportUsers')));
    }

    /**
     * @iterations 10000
     */
    public function deserialize()
    {
        $this->serializer->deserialize('{"args":{"name":"SendNewsletter"},"class":"Bernard:Message:DefaultMessage","timestamp":1373547293,"retries":0}');
    }

    /**
     * @iterations 10000
     */
    public function deserializeUnknown()
    {
        $this->serializer->deserialize('{"args":{"newsletterId":10},"class":"Fixtures:SendNewsletterMessage","timestamp":1373547293,"retries":0}');
    }
}
