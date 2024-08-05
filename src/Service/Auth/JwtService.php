<?php 
declare(strict_types=1);

namespace Src\Service\Auth;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtService
{
  private static $JWT_SECRET_KEY = "my_secret_key";
  private static $JWT_EXPIRATION_TIME = 3600; // 1h

  public function __construct()
  {
      if (getenv('JWT_SECRET_KEY')) {
          self::$JWT_SECRET_KEY = getenv('JWT_SECRET_KEY');
      }
  }

  public static function sign(array $payload): array
  {
      if (empty($payload)) {
          throw new Exception("invalid payload");
      }
      $payload['exp'] = time() + self::$JWT_EXPIRATION_TIME;
      $token = JWT::encode($payload, self::$JWT_SECRET_KEY, 'HS256');

      return [
          'value' => $token
      ];
  }

  public static function verify(string $token)
  {
    try {
        $decoded = JWT::decode($token, new Key(self::$JWT_SECRET_KEY, 'HS256'));
        if(gettype($decoded) == 'object') return (array) $decoded;
        return false;
    } catch (\Firebase\JWT\ExpiredException $e) {
        throw new Error($e->getMessage()) ;
    } catch (\Exception $e) {
        throw new Error('Internal server error');
    }
  }
}