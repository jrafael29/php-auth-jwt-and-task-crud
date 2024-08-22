<?php 
namespace Src\Interface\Feature;
use Src\Dto\Auth\Login\LoginInputDTO;
use Src\Dto\Auth\Login\LoginOutputDTO;
interface Login
{
  public function perform(LoginInputDTO $data): LoginOutputDTO;
}