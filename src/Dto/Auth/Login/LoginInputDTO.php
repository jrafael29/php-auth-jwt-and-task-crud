<?php
declare(strict_types=1);

namespace Src\Dto\Auth\Login;
use Src\ObjectValue\Auth\Email;
use Src\ObjectValue\Auth\Password;
use Src\Interface\InputDTO;

class LoginInputDTO implements InputDTO
{
  public string $email;
  public string $password;

  public function __construct(Email $email, Password $password)
  {
    $this->email = (string) $email;
    $this->password = (string) $password;
  }
}