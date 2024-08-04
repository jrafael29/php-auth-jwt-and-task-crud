<?php 
declare(strict_types=1);
namespace Src\Controller\Task;
use Src\Action\Task\DeleteTaskAction;
use Src\Dto\Task\Create\CreateTaskInputDTO;
use Exception;
class DeleteTaskController 
{
  private DeleteTaskAction $action;
  public function __construct(DeleteTaskAction $action)
  {
    $this->action = $action;
  }

  public function handle(array $body): array
  {
    try{
      $taskId = $body['id'];
      if(!count($body) || !isset($taskId)){
        return [
          'statusCode' => 400,
          'message' => "invalid fields"
        ];
      }
      
      $deleteTaskActionResult = $this->action->perform((int) $taskId);
      $statusCode = $deleteTaskActionResult ? 201 : 200;
      
      return [
        'statusCode' => $statusCode,
        'data' => [
          'success'   => $deleteTaskActionResult,
        ]
      ];
    }catch(\Exception $e){
      return [
        'statusCode' => 500,
        'message' => $e->getMessage()
      ];
    }

  }
}