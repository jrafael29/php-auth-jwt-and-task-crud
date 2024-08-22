<?php 
require_once("./vendor/autoload.php");
header("Content-Type: application/json; charset=utf-8");

use Src\Action\Auth\RegisterAction;
use Src\Controller\Auth\RegisterController;
use Src\Repository\ConfirmationCodeRedisRepository;
use Src\Service\Auth\ConfirmationCodeService;
use Src\Service\Email\ResendEmailService;

try{
  $body = json_decode(file_get_contents("php://input"), true);


  $emailService = new ResendEmailService();
  $emailService->sendConfirmationCodeEmail("rafaelsilva9240@hotmail.com", "alguma coisa");
  // $repository = new ConfirmationCodeRedisRepository(1);
  // $service = new ConfirmationCodeService($repository);
  // $code = $service->generate("josefe");

  $response = [
    'statusCode' => 201,
    'data' => [
      'code' => $code
    ]
  ];

}catch(\Exception $e){
  $response = ['statusCode' => 500,'message' => $e->getMessage()];
}

echo json_encode($response);
die;