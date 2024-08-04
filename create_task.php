<?php 
require_once("./vendor/autoload.php");
header("Content-Type: application/json; charset=utf-8");
date_default_timezone_set('America/Sao_Paulo');

use Src\Middleware\AuthMiddleware;
use Src\Repository\TaskMysqliRepository;
use Src\Action\Task\CreateTaskAction;
use Src\Controller\Task\CreateTaskController;

try{
  $middlewarePass = AuthMiddleware::use(getallheaders());
  $body = json_decode(file_get_contents("php://input"), true);

  [$userId, $userEmail] = [$middlewarePass['id'], $middlewarePass['email']];

  $mysqli               = new mysqli("localhost:3306", "root", "root", "puraodb");
  $taskRepository       = new TaskMysqliRepository($mysqli, $userId);
  $createTaskAction     = new CreateTaskAction($taskRepository);
  $createTaskController = new CreateTaskController($createTaskAction);

  $response = $createTaskController->handle($body);
}catch(\Exception $e){
  $response = ['statusCode' => 500,'message' => 'internal server error'];
}

echo json_encode($response);
die;