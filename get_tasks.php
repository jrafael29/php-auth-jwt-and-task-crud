<?php 
require_once("./vendor/autoload.php");
header("Content-Type: application/json; charset=utf-8");

use Src\Middleware\AuthMiddleware;
use Src\Repository\TaskMysqliRepository;

try{
  $middlewarePass = AuthMiddleware::use(getallheaders());
  [$userId, $userEmail] = [$middlewarePass['id'], $middlewarePass['email']];
  
  $mysqli = new mysqli("localhost:3306", "root", "root", "puraodb");
  $taskRepository = new TaskMysqliRepository($mysqli, $userId);
  $result = $taskRepository->getAll();

  $response = [
    'statusCode' => 200,
    'data' => $result
  ];
}catch(\Exception $e){
  $response = [
    'statusCode' => 500,
    'message' => "{$e->getMessage()}"
  ];
}

echo json_encode($response);
die;