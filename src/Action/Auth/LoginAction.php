<?php
declare(strict_types=1);
namespace Src\Action\Auth;

use Src\Dto\Auth\Login\LoginInputDTO;
use Src\Dto\Auth\Login\LoginOutputDTO;
use Src\Service\Auth\JwtService;
use Src\Service\Auth\PasswordService;
use Src\Interface\Repository\UserRepository;
use Src\Interface\Action\LoginAction as ILoginAction;
use Exception;

class LoginAction implements ILoginAction
{
  public function __construct(private UserRepository $userRepository)
  {}
  
  public function perform(LoginInputDTO $data): LoginOutputDTO
  {
    [$email, $password] = [$data->email, $data->password];
    $userExists = $this->userRepository->getByEmail($email);

    if(!$userExists){
      throw new Exception("user not exits");
    };

    $passwordMatches = PasswordService::comparePassword($userExists['password'], $password);

    if(!$passwordMatches){
      throw new Exception("invalid credentials");
    }

    $jwtSignResult = JwtService::sign([
      'id' => $userExists['id'], 
      'email' => $userExists['email']
    ]);

    return new LoginOutputDTO(token: $jwtSignResult['value']);
  }
}