<?php
declare(strict_types=1);

namespace Src\Dto\Auth\Register;

use Src\Interface\OutputDTO;

class RegisterOutputDTO implements OutputDTO
{
  public int    $id;
  public string $name;
  public string $email;
  public string $password;

  public function __construct(int $id, string $name, string $email, string $password)
  {
    $this->id       = $id;
    $this->name     = $name;
    $this->email    = $email;
    $this->password = $password;
  }
}