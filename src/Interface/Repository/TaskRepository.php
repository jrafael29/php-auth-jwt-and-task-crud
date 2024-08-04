<?php 
namespace Src\Interface\Repository;
use Src\Model\TaskModel;
interface TaskRepository
{
  /**
   * @return TaskModel[]
   */
  public function getAll(): array;

  public function create(string $description);

  public function delete(int $id): bool;

  public function update(int $taskId, string $description = null, bool $done): bool;
}