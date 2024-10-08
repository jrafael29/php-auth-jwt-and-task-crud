<?php
declare(strict_types=1);

namespace Src\Dto\Auth\Login;

use Src\Interface\OutputDTO;


class LoginOutputDTO implements OutputDTO
{
  public function __construct(public string $token = '', public string $message = '')
  {
  }
}