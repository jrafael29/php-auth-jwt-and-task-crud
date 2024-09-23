<?php 
declare(strict_types=1);
namespace Src\Repository;
use Src\Interface\Repository\TaskRepository;
use Src\Model\TaskModel;
use Exception;
use mysqli;
class TaskMysqliRepository implements TaskRepository
{
  private \mysqli $mysqli;
  private int $authUserId;

  public function __construct(int $authUserId)
  {
    $this->authUserId = $authUserId;
    // Definir valores padrão caso as variáveis de ambiente não estejam definidas
    $host = $_ENV['MYSQL_HOST'] ?? 'localhost'; // Valor padrão
    $port = $_ENV['MYSQL_PORT'] ?? '3306';     // Valor padrão para a porta
    $user = $_ENV['MYSQL_USER'] ?? 'root';     // Valor padrão para o usuário
    $password = $_ENV['MYSQL_PASS'] ?? '';      // Pode ser uma string vazia
    $dbName = $_ENV['MYSQL_DB'] ?? '';          // Nome do banco de dados (pode ser vazio)
  
    // Criar a conexão com o MySQL
    $this->mysqli = new \mysqli($host, $user, $password, $dbName, (int)$port);

    // Verificar se houve erro na conexão
    if ($this->mysqli->connect_error) {
        throw new Exception("Connection failed: " . $this->mysqli->connect_error);
    }
  }

  public function __destruct() 
  {
    $this->mysqli->close();
  }

  public function getAll(): array
  {
    $stmt = $this->mysqli->prepare("SELECT t.id, t.user_id, t.description, t.done, t.created_at FROM tasks t WHERE t.user_id = ? LIMIT 50");
    if ($stmt === false) {
        throw new Exception($this->mysqli->error);
    }

    $stmt->bind_param('s', $this->authUserId);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result === false) {
        throw new Exception($stmt->error);
    }
    $tasks = [];
    foreach($result->fetch_all() as $key => $value){
      [$id, $userId, $description, $done, $createdAt] = $value;
      $task = new TaskModel($id, $userId, $description, (bool)$done, $createdAt);
      array_push($tasks, $task());
    }
    $stmt->close();
    return $tasks;
  }

  public function create(string $description)
  {
    if(!$description) throw new Exception("invalid data");
    $stmt = $this->mysqli->prepare("INSERT INTO tasks (user_id, description, done) VALUES (?, ?, 0)");
    if ($stmt === false) {
        throw new Exception($this->mysqli->error);
    }
    $stmt->bind_param('ss', $this->authUserId, $description);
    if ($stmt->execute()) {
      $id = $stmt->insert_id;
      $taskModel = new TaskModel($id, $this->authUserId, $description, false, date("Y-m-d H:i:s"));
      $stmt->close();
      return $taskModel();
    } else {
      $stmt->close();
      throw new Exception($stmt->error);
    }
  }

  public function delete(int $taskId): bool
  {
    if(!$taskId) throw new Exception("invalid data");
    $stmt = $this->mysqli->prepare("DELETE FROM tasks t WHERE t.id = ? AND t.user_id = ?");
    if ($stmt === false) {
        throw new Exception($this->mysqli->error);
    }

    $stmt->bind_param('ss', $taskId, $this->authUserId);
    if ($stmt->execute()) {
      if($stmt->affected_rows){
        return true;
      }
      return false;
    } else {
      $stmt->close();
      throw new Exception($stmt->error);
    }
  }

  public function update(int $taskId, string $description = null, bool $done): bool
  {
    if (!$taskId) throw new Exception("Invalid data");

    $query = "UPDATE tasks SET ";
    $params = [];
    $types = '';

    if ($description !== null) {
        $query .= "description = ?, ";
        $params[] = $description;
        $types .= 's';
    }

    $query .= "done = ? WHERE id = ?";
    $params[] = $done;
    $types .= 'i';
    $params[] = $taskId;
    $types .= 'i';

    $stmt = $this->mysqli->prepare($query);
    if ($stmt === false) {
        throw new Exception($this->mysqli->error);
    }

    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
      $stmt->close();
      return true;
    } else {
      $stmt->close();
      return false;
    }
  }
}
