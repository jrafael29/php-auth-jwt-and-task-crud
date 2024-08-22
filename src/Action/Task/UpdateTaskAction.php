<?php
declare(strict_types=1);
namespace Src\Action\Task;

use Src\Interface\Feature\UpdateTask;
use Src\Interface\Repository\TaskRepository;
use Src\Dto\Task\Update\UpdateTaskInputDTO;
use Src\Dto\Task\Update\UpdateTaskOutputDTO;
use Src\Model\TaskModel;
use Exception;

class UpdateTaskAction implements UpdateTask
{
  private TaskRepository $repository;
  public function __construct(TaskRepository $repository)
  {
    $this->repository = $repository;
  }
  
  public function perform(UpdateTaskInputDTO $data): bool
  {
    return $this->repository->update(
      taskId: $data->taskId, 
      description: $data->description, 
      done: $data->done
    );
  }
}