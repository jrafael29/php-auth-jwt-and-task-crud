<?php 
namespace Src\Interface\Repository;
use Src\Model\TaskModel;
interface ConfirmationCodeRepository
{
  public function getByIdentifier(string $identifier): string | null;

  public function store(string $identifier, string $code): bool;
}