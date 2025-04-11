<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\Exceptions\MqttClientException;

class RelayController extends Controller
{
    private $mqttHost = '127.0.0.1';  // Ganti dengan alamat MQTT broker Anda
    private $mqttPort = 1883;            // Ganti dengan port MQTT broker Anda
    private $clientId = 'LaravelClient';

    public function turnOnRelay()
    {
        try {
            $this->publishMqttMessage('relay', 'ON');
            return redirect()->back()->with('status', 'Relay turned ON');
        } catch (MqttClientException $e) {
            return redirect()->back()->with('error', 'Failed to connect to MQTT broker: ' . $e->getMessage());
        }
    }

    public function turnOffRelay()
    {
        try {
            $this->publishMqttMessage('relay', 'OFF');
            return redirect()->back()->with('status', 'Relay turned OFF');
        } catch (MqttClientException $e) {
            return redirect()->back()->with('error', 'Failed to connect to MQTT broker: ' . $e->getMessage());
        }
    }

    private function publishMqttMessage($topic, $message)
    {
        $mqtt = new MqttClient($this->mqttHost, $this->mqttPort, $this->clientId);

        $mqtt->connect();
        $mqtt->publish($topic, $message, 0);  // QoS 0
        $mqtt->disconnect();
    }
}
