<?php 
namespace Src\Interface\Action;
use Src\Dto\Task\Create\CreateTaskInputDTO;
use Src\Dto\Task\Create\CreateTaskOutputDTO;

interface CreateTaskAction
{
  public function perform(CreateTaskInputDTO $data): CreateTaskOutputDTO;
}