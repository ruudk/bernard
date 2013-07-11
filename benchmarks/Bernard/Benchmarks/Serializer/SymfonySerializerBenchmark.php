<?php

namespace Bernard\Benchmarks\Serializer;

use Bernard\Message\DefaultMessage;
use Bernard\Message\Envelope;
use Bernard\Serializer\SymfonySerializer;
use Bernard\Symfony\DefaultMessageNormalizer;
use Bernard\Symfony\EnvelopeNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;


class SymfonySerializerBenchmark extends \Athletic\AthleticEvent
{
    public function setUp()
    {
        $symfonySerializer = new Serializer(array(new EnvelopeNormalizer, new DefaultMessageNormalizer), array(new JsonEncoder));

        $this->serializer = new SymfonySerializer($symfonySerializer);
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
