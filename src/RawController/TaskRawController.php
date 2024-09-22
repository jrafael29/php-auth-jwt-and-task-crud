<?php 

namespace Src\RawController;

use Src\Http\Request;
use Src\Http\Response;

use Src\Middleware\AuthMiddleware;
use Src\Repository\TaskMysqliRepository;
use Src\Action\Task\GetTasksAction;
use Src\Action\Task\DeleteTaskAction;
use Src\Action\Task\CreateTaskAction;
use Src\Action\Task\UpdateTaskAction;
use Src\Controller\Task\DeleteTaskController;
use Src\Controller\Task\GetTasksController;
use Src\Controller\Task\UpdateTaskController;
use Src\Controller\Task\CreateTaskController;

class TaskRawController 
{

  private static function validateAuthMiddleware(Response $response, $headers): array
  {
    try{
      $middlewarePass = AuthMiddleware::use($headers);
      return [$middlewarePass['id'], $middlewarePass['email']];
    }catch(\Exception $e){
      $response->json([
        'message' => "{$e->getMessage()}"
      ])->status(500)->end();
    } 
  }

  public static function handleGetAll(Request $request, Response $response)
  {
    try{
      [$authUserId, $authUserEmail] = self::validateAuthMiddleware($response, $request->getHeaders());
  
      $taskRepository      = new TaskMysqliRepository($authUserId);
      $getTasksAction      = new GetTasksAction($taskRepository);
      $getTasksController  = new GetTasksController($getTasksAction);
    
      $controllerResponse = $getTasksController->handle();

      $response->json($controllerResponse)->status($controllerResponse['statusCode'])->end();

    }catch(\Exception $e){
      $response->json([
        'message' => "{$e->getMessage()}"
      ])->status(500)->end();
    } 
  }

  // public static function handleGet(Request $request, Response $response, $id)
  // {
  //   try{
  //     $middlewarePass = AuthMiddleware::use($request->getHeaders());
  //     [$authUserId, $authUserEmail] = [$middlewarePass['id'], $middlewarePass['email']];

  //     $response->json($controllerResponse)->status($controllerResponse['statusCode'])->end();

  //   }catch(\Exception $e){
  //     $response->json([
  //       'message' => "{$e->getMessage()}"
  //     ])->status(500)->end();
  //   } 

  // }

  public static function handlePost(Request $request, Response $response)
  {
    try{
      [$authUserId, $authUserEmail] = self::validateAuthMiddleware($response, $request->getHeaders());

      $taskRepository       = new TaskMysqliRepository($authUserId);
      $createTaskAction     = new CreateTaskAction($taskRepository);
      $createTaskController = new CreateTaskController($createTaskAction);
    
      $controllerResponse = $createTaskController->handle($request->getBody());

      $response->json($controllerResponse)->status($controllerResponse['statusCode'])->end();

    }catch(\Exception $e){
      $response->json([
        'message' => "{$e->getMessage()}"
      ])->status(500)->end();
    } 

  }

  public static function handlePut(Request $request, Response $response, $id)
  {
    try{
      [$authUserId, $authUserEmail] = self::validateAuthMiddleware($response, $request->getHeaders());

      $taskRepository          = new TaskMysqliRepository($authUserId);
      $updateTaskAction        = new UpdateTaskAction($taskRepository);
      $updateTaskController    = new UpdateTaskController($updateTaskAction);
    
      $controllerResponse = $updateTaskController->handle([
        'id' => $id,
        ...$request->getBody()
      ]);

      $response->json($controllerResponse)->status($controllerResponse['statusCode'])->end();

    }catch(\Exception $e){
      $response->json([
        'message' => "{$e->getMessage()}"
      ])->status(500)->end();
    } 

  }

  public static function handleDelete(Request $request, Response $response, $id)
  {
    try{
      [$authUserId, $authUserEmail] = self::validateAuthMiddleware($response, $request->getHeaders());

      $taskRepository       = new TaskMysqliRepository($authUserId);
      $deleteTaskAction     = new DeleteTaskAction($taskRepository);
      $deleteTaskController = new DeleteTaskController($deleteTaskAction);

      $controllerResponse = $deleteTaskController->handle(["id" => $id]);

      $response->json($controllerResponse)->status($controllerResponse['statusCode'])->end();
    }catch(\Exception $e){
      $response->json([
        'message' => "{$e->getMessage()}"
      ])->status(500)->end();
    } 

  }

}