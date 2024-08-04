<?php 
namespace Src\Interface\Action;
use Src\Dto\Task\Update\UpdateTaskInputDTO;
use Src\Dto\Task\Update\UpdateTaskOutputDTO;

interface UpdateTaskAction
{
  public function perform(UpdateTaskInputDTO $data);
}