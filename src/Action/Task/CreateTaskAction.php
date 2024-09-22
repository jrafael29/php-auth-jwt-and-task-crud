<?php
declare(strict_types=1);
namespace Src\Action\Task;

use Src\Interface\Feature\CreateTask;
use Src\Interface\Repository\TaskRepository;
use Src\Dto\Task\Create\CreateTaskInputDTO;
use Src\Dto\Task\Create\CreateTaskOutputDTO;
use Exception;

class CreateTaskAction implements CreateTask
{
  private TaskRepository $repository;
  public function __construct(TaskRepository $repository)
  {
    $this->repository = $repository;
  }
  
  public function perform(CreateTaskInputDTO $data): CreateTaskOutputDTO
  {
    $result = $this->repository->create($data->description);
    [$id, $userId, $description, $status, $done, $createdAt] = [$result['id'], $result['user_id'], $result['description'], $result['status'], $result['done'], $result['created_at']];
    return new CreateTaskOutputDTO((int) $id, (int) $userId, (string) $description, (string) $status, (string) $done, $createdAt);
  }
}