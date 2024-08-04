<?php 
namespace Src\Interface;
use Src\Model\TaskModel;
interface TaskRepository
{
  /**
   * @return TaskModel[]
   */
  public function getAll(): array;

  public function create(string $description);
}