<?php 
namespace Src\Interface\Feature;
use Src\Dto\Auth\ConfirmateCode\ConfirmateCodeInputDTO;
use Src\Dto\Auth\ConfirmateCode\ConfirmateCodeOutputDTO;

interface ConfirmateCode
{
  public function perform(ConfirmateCodeInputDTO $data): ConfirmateCodeOutputDTO;
}