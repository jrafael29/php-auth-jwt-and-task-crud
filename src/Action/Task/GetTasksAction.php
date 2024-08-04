<?php
declare(strict_types=1);
namespace Src\Action\Task;

use Src\Interface\TaskRepository;
use Src\Interface\Action\GetTasksAction as IGetTasksAction;
use Exception;

class GetTasksAction implements IGetTasksAction
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