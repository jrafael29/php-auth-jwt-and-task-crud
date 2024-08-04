<?php
declare(strict_types=1);
namespace Src\Action\Auth;

use Src\Dto\Auth\Register\RegisterInputDTO;
use Src\Dto\Auth\Register\RegisterOutputDTO;
use Src\Service\Auth\PasswordService;
use Src\Interface\UserRepository;
use Src\Interface\Action\RegisterAction as IRegisterAction;
use Exception;

class RegisterAction implements IRegisterAction
{
  private UserRepository $userRepository;
  public function __construct(UserRepository $userRepository)
  {
    $this->userRepository = $userRepository;
  }
  
  public function perform(RegisterInputDTO $data): RegisterOutputDTO
  {
    [$name, $email, $password] = [$data->name, $data->email, $data->password];

    $userConflict = $this->userRepository->getByEmail($email);

    if($userConflict){
      throw new Exception("email already in use");
    };

    $hashedPassword = PasswordService::hashPassword($password);
    $userCreatedId = $this->userRepository->create($name, $email, $hashedPassword);

    return new RegisterOutputDTO($userCreatedId, $name, $email, $hashedPassword);
  }
}