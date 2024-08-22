<?php 
namespace Src\Interface\Feature;
use Src\Dto\Auth\Register\RegisterInputDTO;
use Src\Dto\Auth\Register\RegisterOutputDTO;
interface Register
{
  public function perform(RegisterInputDTO $data): RegisterOutputDTO;
}