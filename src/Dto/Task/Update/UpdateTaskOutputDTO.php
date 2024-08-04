<?php
declare(strict_types=1);

namespace Src\Dto\Task\Update;
use Src\Interface\OutputDTO;

class UpdateTaskOutputDTO implements OutputDTO
{
  public function __construct(public string $description)
  {}
}