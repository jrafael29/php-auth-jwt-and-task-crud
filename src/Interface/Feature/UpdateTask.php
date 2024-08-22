<?php 
namespace Src\Interface\Feature;
use Src\Dto\Task\Update\UpdateTaskInputDTO;
use Src\Dto\Task\Update\UpdateTaskOutputDTO;

interface UpdateTask
{
  public function perform(UpdateTaskInputDTO $data);
}