# Wepubsub

The package requires the google cloud pub/sub package.

> composer require wematica/wepubsub

The class **GooglePubSubHandler** uses the Google Cloud Pub/Sub client library to handle publishing and subscribing to messages. The constructor sets up the client with the necessary credentials.

### Methods

> The **publishMessage** method takes the name of the topic to publish to and the message to publish, encodes the message as base64, and publishes it to the specified topic. It returns the ID of the published message.

> The **subscribe** method takes the name of the subscription to subscribe to, a callback function to process incoming messages, and optional configuration options. It sets up a message pull loop that calls the callback function for each incoming message, passing in the decoded message data, and acknowledging the message after processing.

### Usage

You can instantiate the class and use its methods to publish and subscribe to messages in your Laravel PHP application like so:

    $pubsub = new GooglePubSubHandler(['GOOGLE_CLOUD_PROJECT_ID' => '', 'GOOGLE_CLOUD_KEY_FILE_PATH' => '']);

    // Publish a message to a topic
    $topicName = 'my-topic';
    $message = 'Hello, world!';
    $messageId = $pubsub->publishMessage($topicName, $message);
    echo "Published message with ID: $messageId";

    // Subscribe to a subscription and process incoming messages
    $subscriptionName = 'my-subscription';
    $callback = function ($messageData) {
        echo "Received message: $messageData";
    };
    $options = [
        'maxMessages' => 100,
        'returnImmediately' => false,
    ];
    $pubsub->subscribe($subscriptionName, $callback, $options);
    
  
