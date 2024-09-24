<?php
require_once("./vendor/autoload.php");
use PhpAmqpLib\Connection\AMQPStreamConnection;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$rbbHost = $_ENV['RABBITMQ_HOST'];
$rbbPort = (int) $_ENV['RABBITMQ_PORT'];
$rbbUser = $_ENV['RABBITMQ_USER'];
$rbbPass = $_ENV['RABBITMQ_PASS'];
echo "HOST: " .$rbbHost. " PORT: " .$rbbPort. " USER: " .$rbbUser. " PASS: " .$rbbPass;
$connection = new AMQPStreamConnection($rbbHost, $rbbPort, $rbbUser, $rbbPass);
$channel = $connection->channel();

$callback = function($msg) {
  echo "RECEBI UMA MSG: " . $msg->body . " routingkey:".$msg->getRoutingKey()."\n\n";

  // fwrite(fopen('simulador.txt', 'a'), $msg->body . "\n\n");
};

$queues = [
  'user.55.disparo',
  'user.223.disparo',
  'user.542.disparo'
];

foreach($queues as $index => $queue){
  echo " [*] Waiting for messages in ".$queue.". To exit press CTRL+C\n";
  $channel->queue_declare($queue, false, false, false, false);
  $channel->basic_consume($queue, '', false, true, false, false, $callback);
}


try {
  $channel->queue_declare($queue, false, false, false, false);
  $channel->basic_consume($queue, '', false, true, false, false, $callback);
  $channel->consume();
} catch (\Throwable $exception) {
  echo $exception->getMessage();
}
