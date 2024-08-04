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
  private TaskRepository $repository;
  public function __construct(TaskRepository $repository)
  {
    $this->repository = $repository;
  }
  
  public function perform()
  {

  }
}