<?php 
require_once("./vendor/autoload.php");
header("Content-Type: application/json; charset=utf-8");

use Src\Action\Auth\RegisterAction;
use Src\Controller\Auth\RegisterController;
use Src\Repository\UserMysqliRepository;

try{
  $body = json_decode(file_get_contents("php://input"), true);
  
  $mysqli = new mysqli("localhost:3306", "root", "root", "puraodb");

  $userRepository       = new UserMysqliRepository($mysqli);
  $registerAction       = new RegisterAction($userRepository);
  $registerController   = new RegisterController($registerAction);

  $response = $registerController->handle($body);

  echo json_encode($response);
}catch(\Exception $e){
  $response = ['statusCode' => 500,'message' => 'internal server error'];
}

echo json_encode($response);
die;