<?php 
declare(strict_types=1);
namespace Src\Repository;
use Src\Interface\TaskRepository;
use Src\Model\TaskModel;
use Exception;

class TaskMysqliRepository implements TaskRepository
{
  private $mysqli;
  private $authUserId;
  public function __construct($mysqli, $authUserId)
  {
    $this->mysqli = $mysqli;
    $this->authUserId = $authUserId;
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
    $stmt = $this->mysqli->prepare("INSERT INTO tasks (user_id, description) VALUES (?, ?)");
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
}
