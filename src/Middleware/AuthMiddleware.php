<?php 
declare(strict_types=1);
namespace Src\Middleware;
use Src\Service\Auth\JwtService;
use Exception;
class AuthMiddleware
{
  public static function use($requestHeaders)
  {
    try{
      if (!isset($requestHeaders['Authorization']) || empty($requestHeaders['Authorization'])) {
        throw new Exception("invalid authorization header");
      }
      $bearerToken = $requestHeaders['Authorization'];
      $bearerTokenParts = explode("Bearer ", $bearerToken);
      $token = $bearerTokenParts[1];
      return JwtService::verify($token);
    }catch(Exception $e){
      throw new Exception($e->getMessage());
    }
  }
}