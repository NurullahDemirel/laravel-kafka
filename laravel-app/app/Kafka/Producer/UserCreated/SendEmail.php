<?php

namespace App\Kafka\Producer\UserCreated;

use RdKafka\Producer;

class SendEmail
{
    protected Producer $producer;

    public function __construct(Producer $producer)
    {
        $this->producer = $producer;
    }

    public function produce(string $topicName, string $message): void
    {
        $topic = $this->producer->newTopic($topicName);
        $topic->produce(RD_KAFKA_PARTITION_UA, 0, $message);
        $this->producer->flush(10000);
    }
}
