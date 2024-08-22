<?php 
namespace Src\Interface\Feature;
use Src\Dto\Task\Create\CreateTaskInputDTO;
use Src\Dto\Task\Create\CreateTaskOutputDTO;

interface CreateTask
{
  public function perform(CreateTaskInputDTO $data): CreateTaskOutputDTO;
}