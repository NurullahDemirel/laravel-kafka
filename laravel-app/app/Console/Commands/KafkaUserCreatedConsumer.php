<?php

namespace App\Console\Commands;

use App\Models\Address;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use RdKafka\Conf;
use RdKafka\KafkaConsumer;
use RdKafka\Message;

class KafkaUserCreatedConsumer extends Command
{
    protected $signature = 'kafka:consume-user-created';
    protected $description = 'Consume user-created messages from Kafka';

    public function handle()
    {
        $conf = new Conf();
        $conf->set('metadata.broker.list', env('KAFKA_BROKER', 'kafka:9092'));
        $conf->set('group.id', 'laravel-user-group');
        $conf->set('auto.offset.reset', 'earliest');

        $consumer = new KafkaConsumer($conf);
        $consumer->subscribe(['user-created']);

        $this->info("Listening to 'user-created' topic...");

        while (true) {
            $message = $consumer->consume(10000); // 10 saniye

            switch ($message->err) {
                case RD_KAFKA_RESP_ERR_NO_ERROR:
                    $this->handleMessage($message);
                    break;
                case RD_KAFKA_RESP_ERR__PARTITION_EOF:
                    $this->warn("No more messages.");
                    break;
                case RD_KAFKA_RESP_ERR__TIMED_OUT:
                    $this->warn("Timed out...");
                    break;
                default:
                    $this->error("Kafka error: " . $message->errstr());
                    break;
            }
        }
    }

    protected function handleMessage(Message $message)
    {
        $payload = json_decode($message->payload, true);

        if (!$payload) {
            $this->error('Invalid JSON message');
            return;
        }

        Log::info('new user :' . json_encode($payload));

        Address::create([
            'user_id' => $payload['user_id'],
            'address' => $payload['address'],
        ]);

    }
}
