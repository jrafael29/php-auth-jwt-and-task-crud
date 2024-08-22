<?php 
require_once("./vendor/autoload.php");
header("Content-Type: application/json; charset=utf-8");
date_default_timezone_set('America/Sao_Paulo');

use Src\Middleware\AuthMiddleware;
use Src\Repository\TaskMysqliRepository;
use Src\Action\Task\UpdateTaskAction;
use Src\Controller\Task\UpdateTaskController;

try{
  $middlewarePass = AuthMiddleware::use(getallheaders());
  $body = json_decode(file_get_contents("php://input"), true);
  
  [$authUserId, $authUserEmail] = [$middlewarePass['id'], $middlewarePass['email']];

  $taskRepository          = new TaskMysqliRepository($authUserId);
  $updateTaskAction        = new UpdateTaskAction($taskRepository);
  $updateTaskController    = new UpdateTaskController($taskAction);

  $response = $updateTaskController->handle($body);

}catch(\Exception $e){
  $response = ['statusCode' => 500,'message' => $e->getMessage()];
}

echo json_encode($response);
die;