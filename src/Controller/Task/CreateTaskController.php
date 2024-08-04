<?php 
declare(strict_types=1);
namespace Src\Controller\Task;
use Src\Action\Task\CreateTaskAction;
use Src\Dto\Task\Create\CreateTaskInputDTO;
use Exception;
class CreateTaskController 
{
  private CreateTaskAction $action;
  public function __construct(CreateTaskAction $action)
  {
    $this->action = $action;
  }

  public function handle(array $body): array
  {
    try{
      $description = $body['description'];
      if(!count($body) || !isset($description)){
        return [
          'statusCode' => 400,
          'message' => "invalid fields"
        ];
      }
      
      $createTaskActionResult = $this->action->perform(
        new CreateTaskInputDTO(
          description: $description
        )
      );
      
      if(!$createTaskActionResult) throw new Exception("internal server error");

      return ['statusCode' => 200,'data' => [
        'id'          => $createTaskActionResult->id,
        'user_id'     => $createTaskActionResult->userId,
        'description' => $createTaskActionResult->description,
        'status'      => $createTaskActionResult->status,
        'created_at'  => $createTaskActionResult->createdAt
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