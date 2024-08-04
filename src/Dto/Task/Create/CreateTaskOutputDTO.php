<?php
declare(strict_types=1);

namespace Src\Dto\Task\Create;
use Src\Interface\OutputDTO;

class CreateTaskOutputDTO implements OutputDTO
{
  public function __construct(  
    public int    $id,
    public int    $userId,
    public string $description,
    public string $status,
    public string $createdAt,
  )
  {}
}