<?php
declare(strict_types=1);
namespace Src\Action\Task;

use Src\Interface\Repository\TaskRepository;
use Src\Interface\Feature\GetTasks;
use Exception;

class GetTasksAction implements GetTasks
{
  private TaskRepository $repository;
  public function __construct(TaskRepository $repository)
  {
    $this->repository = $repository;
  }
  
  public function perform()
  {
    return $this->repository->getAll();
  }
}