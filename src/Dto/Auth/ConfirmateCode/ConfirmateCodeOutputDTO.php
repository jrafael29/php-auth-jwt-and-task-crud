<?php
declare(strict_types=1);

namespace Src\Dto\Auth\ConfirmateCode;

use Src\Interface\OutputDTO;


class ConfirmateCodeOutputDTO implements OutputDTO
{
  public function __construct(public string $token = '', public string $message = '')
  {
  }
}