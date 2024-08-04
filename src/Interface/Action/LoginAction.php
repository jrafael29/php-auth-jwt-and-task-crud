<?php 
namespace Src\Interface\Action;
use Src\Dto\Auth\Login\LoginInputDTO;
use Src\Dto\Auth\Login\LoginOutputDTO;
interface LoginAction
{
  public function perform(LoginInputDTO $data): LoginOutputDTO;
}