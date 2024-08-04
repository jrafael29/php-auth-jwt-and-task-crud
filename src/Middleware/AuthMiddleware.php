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
      $bearerToken = $requestHeaders['Authorization'];
      if(!isset($bearerToken)){
        throw new Exception("invalid authorization header");
      }
      $bearerTokenParts = explode("Bearer ", $requestHeaders['Authorization']);
      $token = $bearerTokenParts[1];
      return JwtService::verify($token);
    }catch(Exception $e){
      throw new Exception($e->getMessage());
    }
  }
}