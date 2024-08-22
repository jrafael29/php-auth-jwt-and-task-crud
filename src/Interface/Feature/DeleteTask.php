<?php 
namespace Src\Interface\Feature;
use Src\Dto\Task\Create\CreateTaskInputDTO;
use Src\Dto\Task\Create\CreateTaskOutputDTO;

interface DeleteTask
{
  public function perform(int $taskId): bool;
}