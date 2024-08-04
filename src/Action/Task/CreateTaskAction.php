<?php
declare(strict_types=1);
namespace Src\Action\Task;

use Src\Dto\Auth\Register\RegisterInputDTO;
use Src\Interface\Action\CreateTaskAction as ICreateTaskAction;
use Src\Interface\TaskRepository;
use Src\Dto\Task\Create\CreateTaskInputDTO;
use Src\Dto\Task\Create\CreateTaskOutputDTO;
use Exception;

class CreateTaskAction implements ICreateTaskAction
{
  private TaskRepository $repository;
  public function __construct(TaskRepository $repository)
  {
    $this->repository = $repository;
  }
  
  public function perform(CreateTaskInputDTO $data): CreateTaskOutputDTO
  {
    $result = $this->repository->create($data->description);
    [$id, $userId, $description, $status, $createdAt] = [$result['id'], $result['user_id'], $result['description'], $result['status'], $result['created_at']];
    return new CreateTaskOutputDTO((int) $id, (int) $userId, (string) $description, (string) $status, $createdAt);
  }
}