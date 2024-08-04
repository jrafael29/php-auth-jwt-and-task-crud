<?php 
declare(strict_types=1);
namespace Src\Controller\Task;
use Src\Action\Task\UpdateTaskAction;
use Src\Dto\Task\Update\UpdateTaskInputDTO;
use Exception;
class UpdateTaskController 
{
  private UpdateTaskAction $action;
  public function __construct(UpdateTaskAction $action)
  {
    $this->action = $action;
  }

  public function handle(array $body): array
  {
    try{
      $taskId = $body['id'];
      $description = $body['description'];
      $done = $body['done'];
      if(!count($body) || !isset($taskId) || !isset($description) || !isset($done)){
        return [
          'statusCode' => 400,
          'message' => "invalid fields"
        ];
      }
      
      $updateTaskActionResult = $this->action->perform(
        new UpdateTaskInputDTO(
          taskId: (int) $taskId,
          description: (string) $description,
          done: (bool) $done
        )
      );
      
      return [
        'statusCode' => 200,
        'data' => [
          'success'   => $updateTaskActionResult,
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