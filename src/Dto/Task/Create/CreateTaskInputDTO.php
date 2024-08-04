<?php
declare(strict_types=1);

namespace Src\Dto\Task\Create;
use Src\Interface\InputDTO;

class CreateTaskInputDTO implements InputDTO
{
  public function __construct(public string $description)
  {}
}