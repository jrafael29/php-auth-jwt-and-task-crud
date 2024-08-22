<?php
namespace Src\Service\Email;
use Src\Interface\Service\EmailService;
use Resend;
use Dotenv\Dotenv;
class ResendEmailService implements EmailService
{
  private string $apiKey;

  public function __construct()
  {
    $this->apiKey = (string) $_ENV['RESEND_API_KEY'] ?? "YOUR_RESEND_API_KEY";
  }

  public function sendConfirmationCodeEmail($toEmail, $code)
  {
    $resend = Resend::client($this->apiKey);
    $resend->emails->send([
      'from' => 'Josef <josef@resend.dev>',
      'to' => [$toEmail],
      'subject' => 'Codigo de confirmação',
      'html' => "Este é o seu codigo de confirmação: <strong>".$code."</strong>",
    ]);
  }
}