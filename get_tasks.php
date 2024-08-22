<?php 
require_once("./vendor/autoload.php");
header("Content-Type: application/json; charset=utf-8");

use Src\Middleware\AuthMiddleware;
use Src\Repository\TaskMysqliRepository;
use Src\Action\Task\GetTasksAction;
use Src\Controller\Task\GetTasksController;

try{
  $middlewarePass = AuthMiddleware::use(getallheaders());

  [$authUserId, $authUserEmail] = [$middlewarePass['id'], $middlewarePass['email']];
  
  $taskRepository      = new TaskMysqliRepository($authUserId);
  $getTasksAction      = new GetTasksAction($taskRepository);
  $getTasksController  = new GetTasksController($getTasksAction);

  $response = $getTasksController->handle();
}catch(\Exception $e){
  $response = [
    'statusCode' => 500,
    'message' => $e->getMessage()
  ];
}

echo json_encode($response);
die;