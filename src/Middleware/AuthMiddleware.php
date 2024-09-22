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
      // echo json_encode($requestHeaders);
      if (!isset($requestHeaders['authorization']) || empty($requestHeaders['authorization'])) {
        throw new Exception("invalid authorization header");
      }
      $bearerToken = $requestHeaders['authorization'];
      $bearerTokenParts = explode("Bearer ", $bearerToken);
      $token = $bearerTokenParts[1];
      return JwtService::verify($token);
    }catch(Exception $e){
      throw new Exception($e->getMessage());
    }
  }
}