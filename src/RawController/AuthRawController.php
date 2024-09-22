<?php 

namespace Src\RawController;

use Src\Http\Request;
use Src\Http\Response;

use Src\Action\Auth\LoginAction;
use Src\Controller\Auth\LoginController;
use Src\Repository\UserMysqliRepository;
use Src\Repository\ConfirmationCodeRedisRepository;
use Src\Service\Auth\ConfirmationCodeService;
use Src\Service\Email\ResendEmailService;

use Src\Action\Auth\ConfirmateCodeAction;
use Src\Controller\Auth\ConfirmateCodeController;

use Src\Action\Auth\RegisterAction;
use Src\Controller\Auth\RegisterController;

class AuthRawController 
{

  public static function handleLogin(Request $request, Response $response)
  {
    try{
  
      $userRepository                = new UserMysqliRepository();
      $confirmationCodeRepository    = new ConfirmationCodeRedisRepository();
      $confirmationCodeService       = new ConfirmationCodeService($confirmationCodeRepository);
      $emailService                  = new ResendEmailService();
      $loginAction                   = new LoginAction($userRepository, $confirmationCodeService, $emailService);
      $loginController               = new LoginController($loginAction);
      $controllerResponse = $loginController->handle($request->getBody());

      $response->json($controllerResponse)->status($controllerResponse['statusCode'])->end();

    }catch(\Exception $e){
      $response->json([
        'message' => "{$e->getMessage()}"
      ])->status(500)->end();
    } 
  }
  
  public static function handleConfirmateCode(Request $request, Response $response)
  {
    try{
  
      $userRepository                  = new UserMysqliRepository();
      $confirmationCodeRedisRepository = new ConfirmationCodeRedisRepository();
      $confirmationCodeService         = new ConfirmationCodeService($confirmationCodeRedisRepository);
      $action                          = new ConfirmateCodeAction($userRepository, $confirmationCodeService);
      $controller                      = new ConfirmateCodeController($action);
      
      $controllerResponse = $controller->handle($request->getBody());

      $response->json($controllerResponse)->status($controllerResponse['statusCode'])->end();

    }catch(\Exception $e){
      $response->json([
        'message' => "{$e->getMessage()}"
      ])->status(500)->end();
    } 
  }

  public static function handleSignup(Request $request, Response $response)
  {
    try{
  
      $userRepository       = new UserMysqliRepository();
      $registerAction       = new RegisterAction($userRepository);
      $registerController   = new RegisterController($registerAction);
    
      $controllerResponse = $registerController->handle($request->getBody());

      $response->json($controllerResponse)->status($controllerResponse['statusCode'])->end();

    }catch(\Exception $e){
      $response->json([
        'message' => "{$e->getMessage()}"
      ])->status(500)->end();
    } 
  }


  
}