<?php
declare(strict_types=1);

namespace Src\Dto\Task\Update;
use Src\Interface\InputDTO;

class UpdateTaskInputDTO implements InputDTO
{
  public function __construct(public int $taskId, public string $description, public bool $done)
  {}
}