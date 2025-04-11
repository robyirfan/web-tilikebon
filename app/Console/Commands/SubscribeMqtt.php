<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use Illuminate\Support\Facades\Broadcast;
use App\Events\MessageReceived;

class SubscribeMqtt extends Command
{
    protected $signature = 'mqtt:subscribe';
    protected $description = 'Subscribe to MQTT topic and broadcast messages';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $mqtt = app(MqttClient::class);

        $mqtt->connect();
        $mqtt->subscribe(env('MQTT_TOPIC'), function (string $topic, string $message) {
            event(new MessageReceived($message));
        });

        $this->info('Subscribed to MQTT topic and broadcasting messages.');
        $mqtt->loop();
    }
}