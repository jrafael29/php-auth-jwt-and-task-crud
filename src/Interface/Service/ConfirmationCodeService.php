<?php 
namespace Src\Interface\Service;
interface ConfirmationCodeService
{
  public function generate(string $identifier);
  public function validate($code, $identifier);
}