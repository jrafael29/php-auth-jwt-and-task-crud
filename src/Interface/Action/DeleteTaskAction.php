<?php 
namespace Src\Interface\Action;
use Src\Dto\Task\Create\CreateTaskInputDTO;
use Src\Dto\Task\Create\CreateTaskOutputDTO;

interface DeleteTaskAction
{
  public function perform(int $taskId): bool;
}