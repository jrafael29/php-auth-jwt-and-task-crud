<?php 
declare(strict_types=1);
namespace Src\Controller\Task;
use Src\Action\Task\GetTasksAction;
use Exception;

class GetTasksController 
{
  public function __construct(private GetTasksAction $action)
  {}

  public function handle(): array
  {
    try{
      
      $getTasksActionResult = $this->action->perform();
      
      if(!$getTasksActionResult) throw new Exception("internal server error");

      return ['statusCode' => 200,'data' => [
        ...$getTasksActionResult
      ]];
    }catch(\Exception $e){
      // reportar $e->getMessage
      return [
        'statusCode' => 500,
        'message' => $e->getMessage()
      ];
    }

  }
}