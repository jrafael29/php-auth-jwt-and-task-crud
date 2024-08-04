<?php 
require_once("./vendor/autoload.php");
header("Content-Type: application/json; charset=utf-8");

use Src\Middleware\AuthMiddleware;
use Src\Repository\TaskMysqliRepository;
use Src\Action\Task\DeleteTaskAction;
use Src\Controller\Task\DeleteTaskController;

try{
  $middlewarePass = AuthMiddleware::use(getallheaders());
  $body = json_decode(file_get_contents("php://input"), true);

  [$userId, $userEmail] = [$middlewarePass['id'], $middlewarePass['email']];
  
  $mysqli               = new mysqli("localhost:3306", "root", "root", "puraodb");
  $taskRepository       = new TaskMysqliRepository($mysqli, $userId);
  $deleteTaskAction     = new DeleteTaskAction($taskRepository);
  $deleteTaskController = new DeleteTaskController($deleteTaskAction);
  
  $response = $deleteTaskController->handle($body);
}catch(\Exception $e){
  $response = [
    'statusCode' => 500,
    'message' => "{$e->getMessage()}"
  ];
}

echo json_encode($response);
die;