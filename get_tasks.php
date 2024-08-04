<?php 
require_once("./vendor/autoload.php");
header("Content-Type: application/json; charset=utf-8");

use Src\Middleware\AuthMiddleware;
use Src\Repository\TaskMysqliRepository;
use Src\Action\Task\GetTasksAction;
use Src\Controller\Task\GetTasksController;

try{
  $middlewarePass = AuthMiddleware::use(getallheaders());
  [$userId, $userEmail] = [$middlewarePass['id'], $middlewarePass['email']];
  
  $mysqli = new mysqli("localhost:3306", "root", "root", "puraodb");
  $getTasksRepository  = new TaskMysqliRepository($mysqli, $userId);
  $getTasksAction      = new GetTasksAction($getTasksRepository);
  $taskController      = new GetTasksController($getTasksAction);

  $response = $taskController->handle();
}catch(\Exception $e){
  $response = [
    'statusCode' => 500,
    'message' => $e->getMessage()
  ];
}

echo json_encode($response);
die;