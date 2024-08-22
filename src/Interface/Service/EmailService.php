<?php 
namespace Src\Interface\Service;
interface EmailService
{
  public function sendConfirmationCodeEmail($toEmail, $code);
}