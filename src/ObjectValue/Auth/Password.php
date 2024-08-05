<?php 
declare(strict_types=1);
namespace Src\ObjectValue\Auth;

class Password 
{
  public function __construct(private string $password)
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