<?php
declare(strict_types=1);

namespace Src\Dto\Auth\Login;

use Src\Interface\OutputDTO;


class LoginOutputDTO implements OutputDTO
{
  public string $token;

  public function __construct(string $token)
  {
    $this->token = $token;
  }
}