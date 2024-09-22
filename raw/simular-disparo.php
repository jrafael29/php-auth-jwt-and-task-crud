<?php 
require_once("../vendor/autoload.php");
header("Content-Type: application/json; charset=utf-8");
date_default_timezone_set('America/Sao_Paulo');

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

try{
  $body = json_decode(file_get_contents("php://input"), true);

  if(!isset($body['id']) || !isset($body['content'])){
    $response = ['statusCode' => 500,'message' => 'invalid data'];
    echo json_encode($response);
    die;
  }

  $queueName = "user.".$body['id'].".disparo";
  $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
  $channel = $connection->channel();
  $channel->queue_declare($queueName, false, false, false, false);
  
  // $body['id'], $body['content']
  $times = 500;
  
  for($i = 0; $i <= $times - 1; $i++) {
    $msg = new AMQPMessage(json_encode([
      'user_id' => $body['id'],
      'content' => $body['content'] . " - " . $i,
      'queue' => $queueName
    ]));
    $channel->basic_publish($msg, '', $queueName);
  }
  $channel->close();
  $connection->close();

  $response = ['statusCode' => 200,'message' => 'success'];
}catch(\Exception $e){
  $response = ['statusCode' => 500,'message' => 'internal server error'];
}

echo json_encode($response);
die;