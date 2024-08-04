<?php 
declare(strict_types=1);
namespace Src\Repository;
use Src\Interface\UserRepository;

class UserMysqliRepository implements UserRepository
{
  private $mysqli;
  public function __construct($mysqli)
  {
    $this->mysqli = $mysqli;
  }

  public function __destruct() 
  {
    $this->mysqli->close();
  }

  public function getByEmail($email)
  {
    $stmt = $this->mysqli->prepare("SELECT u.id, u.name, u.email, u.password FROM users u WHERE u.email = ? LIMIT 1");
    if ($stmt === false) {
        throw new Exception('Prepare Error: ' . $this->mysqli->error);
    }

    $stmt->bind_param('s', $email);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result === false) {
        throw new Exception('Execute Error: ' . $stmt->error);
    }

    $user = $result->fetch_assoc();
    $stmt->close();

    return $user;
  }

  public function create($name, $email, $password)
  {
    $stmt = $this->mysqli->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    if ($stmt === false) {
      // die('Prepare Error (' . $this->mysqli->errno . ') ' . $this->mysqli->error);
      return false;
    }

    $stmt->bind_param("sss", $name, $email, $password);
    
    if ($stmt->execute()) {
      $id = $stmt->insert_id;
      $stmt->close();
      return $id;
    } else {
      $stmt->close();
      return false;
      // die('Execute Error (' . $this->mysqli->errno . ') ' . $this->mysqli->error);
    }
  }

}
