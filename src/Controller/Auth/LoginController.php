<?php 
declare(strict_types=1);
namespace Src\Controller\Auth;
use Src\Action\Auth\RegisterAction;
use Src\Dto\Auth\Login\LoginInputDTO;
use Src\ObjectValue\Auth\Email;
use Src\ObjectValue\Auth\Password;
use Src\Interface\Action\LoginAction;


class LoginController 
{
  private LoginAction $action;
  public function __construct(LoginAction $action)
  {
    $this->action = $action;
  }

  public function handle(array $body): array
  {
    try{
      if(!count($body) || !isset($body['email']) || !isset($body['password'])){
        return [
          'statusCode' => 400,
          'message' => "invalid fields"
        ];
      }
      
      $loginActionResult = $this->action->perform(
        new LoginInputDTO(
          email: new Email($body['email']), 
          password: new Password($body['password'])
        )
      );

      if($loginActionResult){
        return ['statusCode' => 200,'data' => [
          'token' => $loginActionResult->token
        ]];
      }
      return ['statusCode' => 500,'message' => "deu ruim"];
    }catch(\Exception $e){
      // reportar $e->getMessage
      return [
        'statusCode' => 500,
        'message' => $e->getMessage()
      ];
    }

  }
}