<?php

namespace Wepubsub;

use Google\Cloud\PubSub\PubSubClient;

class GooglePubSubHandler
{
    protected $pubsub;

    public function __construct($config = array())
    {
        $this->pubsub = new PubSubClient([
            'projectId' => $config['GOOGLE_CLOUD_PROJECT_ID'],
            'keyFilePath' => $config['GOOGLE_CLOUD_KEY_FILE_PATH'],
        ]);
    }

    /**
     * Publishes a message to a specified topic.
     *
     * @param string $topicName The name of the topic to publish to.
     * @param string $message The message to publish.
     * @return string The message ID.
     */
    public function publishMessage($topicName, $message)
    {
        $topic = $this->pubsub->topic($topicName);
        $data = [
            'data' => base64_encode($message),
        ];
        $message = $topic->publish($data);
        return $message->id();
    }

    /**
     * Subscribes to a specified subscription and processes incoming messages.
     *
     * @param string $subscriptionName The name of the subscription to subscribe to.
     * @param callable $callback The callback function to process incoming messages.
     * @param array $options Optional configuration options.
     */
    public function subscribe($subscriptionName, $callback, $options = [])
    {
        $subscription = $this->pubsub->subscription($subscriptionName);
        $subscription->pull(function ($message) use ($callback) {
            $callback(base64_decode($message->data()));
            $message->ack();
        }, $options);
    }
}