<?php
declare(strict_types=1);

namespace Src\Dto\Auth\ConfirmateCode;
use Src\ObjectValue\Auth\Email;
use Src\ObjectValue\Auth\Password;
use Src\Interface\InputDTO;

class ConfirmateCodeInputDTO implements InputDTO
{
  public string $email;
  public string $code;

  public function __construct(Email $email, string $code)
  {
    $this->email = (string) $email;
    $this->code = $code;
  }
}