<?php 
declare(strict_types=1);
namespace Src\ObjectValue\Auth;

class Email 
{
  public function __construct(private string $email)
  {
    $this->email = $email;
    if (!$this->validate()) {
      throw new \Exception("invalid email");
    }
  }

  private function validate(): bool
  {
    return filter_var($this->email, FILTER_VALIDATE_EMAIL) !== false;
  }

  public function __toString() {
    return $this->email;
  }
}