<?php 
namespace Src\Interface;
use Src\Dto\Auth\Register\RegisterInputDTO;
use Src\Interface\InputDto;
use Src\Interface\OutputDto;
interface UserAction
{
  public function perform(InputDto $data): OutputDto;
}