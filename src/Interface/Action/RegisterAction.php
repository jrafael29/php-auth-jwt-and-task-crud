<?php 
namespace Src\Interface\Action;
use Src\Dto\Auth\Register\RegisterInputDTO;
use Src\Dto\Auth\Register\RegisterOutputDTO;
interface RegisterAction
{
  public function perform(RegisterInputDTO $data): RegisterOutputDTO;
}