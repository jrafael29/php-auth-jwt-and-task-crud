<?php 
declare(strict_types=1);
namespace Src\Repository;
use Src\Interface\Repository\UserRepository;

class UserMysqliRepository implements UserRepository
{
  private \mysqli $mysqli;
  public function __construct()
  {
      // Definir valores padrão caso as variáveis de ambiente não estejam definidas
      $host = $_ENV['MYSQL_HOST'] ?? 'localhost'; // Valor padrão
      $port = $_ENV['MYSQL_PORT'] ?? '3306';     // Valor padrão para a porta
      $user = $_ENV['MYSQL_USER'] ?? 'root';     // Valor padrão para o usuário
      $password = $_ENV['MYSQL_PASS'] ?? '';      // Pode ser uma string vazia
      $dbName = $_ENV['MYSQL_DB'] ?? '';          // Nome do banco de dados (pode ser vazio)
      // echo "host" .$host. " port" .$port. " user" .$user. " pass" .$password. " dbname" . $dbName;
      // Criar a conexão com o MySQL
      $this->mysqli = new \mysqli($host, $user, $password , $dbName, (int)$port);

      // Verificar se houve erro na conexão
      if ($this->mysqli->connect_error) {
          throw new Exception("Connection failed: " . $this->mysqli->connect_error);
      }
  }

  public function __destruct() 
  {
    $this->mysqli->close();
  }

  public function getByEmail($email): array
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
    if(!$user) return [];
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
