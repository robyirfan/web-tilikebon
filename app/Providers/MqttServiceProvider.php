<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;

class MqttServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(MqttClient::class, function ($app) {
            $settings = (new ConnectionSettings)
                ->setUsername(env('MQTT_USERNAME'))
                ->setPassword(env('MQTT_PASSWORD'));

            return new MqttClient(
                env('MQTT_HOST'),
                env('MQTT_PORT'),
                'clientId',
                MqttClient::MQTT_3_1 // Pastikan ini adalah string yang valid
            );
        });
    }

    public function boot()
    {
        //
    }
}