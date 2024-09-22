<?php 
require_once("../vendor/autoload.php");
header("Content-Type: application/json; charset=utf-8");

use Src\Action\Auth\ConfirmateCodeAction;
use Src\Controller\Auth\ConfirmateCodeController;
use Src\Repository\UserMysqliRepository;
use Src\Repository\ConfirmationCodeRedisRepository;
use Src\Service\Auth\ConfirmationCodeService;
use Src\Service\Email\ResendEmailService;

try{
  $body = json_decode(file_get_contents("php://input"), true);

  $userRepository                  = new UserMysqliRepository();
  $confirmationCodeRedisRepository = new ConfirmationCodeRedisRepository();
  $confirmationCodeService         = new ConfirmationCodeService($confirmationCodeRedisRepository);
  $action                          = new ConfirmateCodeAction($userRepository, $confirmationCodeService);
  $controller                      = new ConfirmateCodeController($action);
  
  $response = $controller->handle($body);
  

}catch(\Exception $e){
  $response = ['statusCode' => 500,'message' => $e->getMessage()];
}
echo json_encode($response);
die;