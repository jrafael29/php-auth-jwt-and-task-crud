<?php 
declare(strict_types=1);
namespace Src\ObjectValue\Auth;

class Password 
{
  private string $password;
  public function __construct(string $password)
  {
    $this->password = $password;
    if (!$this->validate()) {
      throw new \Exception("invalid password");
    }
  }

  private function validate(): bool
  {
    return strlen($this->password) > 3;
  }

  public function __toString() {
    return $this->password;
  }
}