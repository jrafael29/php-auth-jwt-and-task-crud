<?php
require_once("../vendor/autoload.php");

use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();
// $queueName = "disparos_testaveis";
// $channel->queue_declare($queueName, false, false, false, false);
// $channel->queue_declare('outra', false, false, false, false);


$callback = function($msg) {
  echo "RECEBI UMA MSG: " . $msg->body . " routingkey:".$msg->getRoutingKey()."\n\n";

  fwrite(fopen('simulador.txt', 'a'), $msg->body . "\n\n");
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

// while(true){
//   echo "alguma coisa";

//   usleep(50 * 10000);
// }

