<?php
declare(strict_types=1);

namespace Src\Dto\Auth\Register;
use Src\ObjectValue\Auth\Email;
use Src\ObjectValue\Auth\Password;
use Src\Interface\OutputDTO;
use Src\Interface\InputDTO;

class RegisterInputDTO implements InputDTO
{
  public string $name;
  public string $email;
  public string $password;

  public function __construct(string $name, Email $email, Password $password)
  {
    $this->name = (string) $name;
    $this->email = (string) $email;
    $this->password = (string) $password;
  }
}