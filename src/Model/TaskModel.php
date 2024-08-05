<?php 
declare(strict_types=1);
namespace Src\Model;

class TaskModel
{
  public function __construct(
    private int         $id, 
    private int         $userId, 
    private string      $description, 
    private bool        $done,
    private string      $createdAt
    )
  {}

  public function __invoke()
  {
    return [
      'id'          => $this->getId(),
      'user_id'     => $this->getUserId(),
      'description' => $this->getDescription(),
      'status'      => $this->getStatus(),
      'done'        => $this->getDone(),
      'created_at'  => $this->getCreatedAt()
    ];
  }

  public function getId()
  {
    return $this->id;
  }
  public function getUserId()
  {
    return $this->userId;
  }
  public function getDescription()
  {
    return $this->description;
  }
  public function getDone()
  {
    return $this->done;
  }
  public function getStatus()
  {
    return $this->done ? "Concluido" : "A Fazer";
  }
  public function getCreatedAt()
  {
    return $this->createdAt;
  }
}