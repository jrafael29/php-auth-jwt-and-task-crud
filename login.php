<?php 
require_once("./vendor/autoload.php");
header("Content-Type: application/json; charset=utf-8");

use Src\Action\Auth\LoginAction;
use Src\Controller\Auth\LoginController;
use Src\Repository\UserMysqliRepository;
use Src\Repository\ConfirmationCodeRedisRepository;
use Src\Service\Auth\ConfirmationCodeService;
use Src\Service\Email\ResendEmailService;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

try{
  $body = json_decode(file_get_contents("php://input"), true);

  $userRepository                = new UserMysqliRepository();
  $confirmationCodeRepository    = new ConfirmationCodeRedisRepository();
  $confirmationCodeService       = new ConfirmationCodeService($confirmationCodeRepository);
  $emailService                  = new ResendEmailService();
  $loginAction                   = new LoginAction($userRepository, $confirmationCodeService, $emailService);
  $loginController               = new LoginController($loginAction);
  
  $response = $loginController->handle($body);

}catch(\Exception $e){
  $response = ['statusCode' => 500,'message' => $e->getMessage()];
}
echo json_encode($response);
die;