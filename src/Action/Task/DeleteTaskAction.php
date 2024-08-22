<?php
declare(strict_types=1);
namespace Src\Action\Task;

use Src\Interface\Feature\DeleteTask;
use Src\Interface\Repository\TaskRepository;
use Src\Dto\Task\Create\CreateTaskInputDTO;
use Src\Dto\Task\Create\CreateTaskOutputDTO;
use Exception;

class DeleteTaskAction implements DeleteTask
{
  private TaskRepository $repository;
  public function __construct(TaskRepository $repository)
  {
    $this->repository = $repository;
  }
  
  public function perform(int $taskId): bool
  {
    return $this->repository->delete($taskId);
  }
}