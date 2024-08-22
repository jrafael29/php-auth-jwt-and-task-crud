<?php 
declare(strict_types=1);
namespace Src\Repository;
use Src\Interface\Repository\ConfirmationCodeRepository;
use Src\Model\TaskModel;
use Exception;

class ConfirmationCodeRedisRepository implements ConfirmationCodeRepository
{
    private \Redis $redisConn;

    public function __construct()
    {
        $this->redisConn = new \Redis();
        $this->redisConn->connect('192.168.0.4', 6379, 2.5);
    }

    public function __destruct() 
    {
        $this->redisConn->close();
    }

    // Defina os métodos do repositório aqui
    public function store(string $identifier, string $code): bool
    {
      $result = $this->redisConn->setex($identifier, 300, $code); // expires in 5 minutes
      return $result;
    }

    public function getByIdentifier(string $identifier): string | null
    {
      $result = $this->redisConn->get($identifier);
      if($result) return $result;
      return null;
    }
}
