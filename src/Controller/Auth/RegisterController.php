<?php 
declare(strict_types=1);
namespace Src\Controller\Auth;
use Src\Action\Auth\RegisterAction;
use Src\Dto\Auth\Register\RegisterInputDTO;
use Src\ObjectValue\Auth\Email;
use Src\ObjectValue\Auth\Password;
use Src\Interface\Action\RegisterAction as IRegisterAction;


class RegisterController 
{
  private IRegisterAction $action;
  public function __construct(IRegisterAction $action)
  {
    $this->action = $action;
  }

  public function handle(array $body): array
  {
    try{
      if(!count($body) || !isset($body['name']) || !isset($body['email']) || !isset($body['password'])){
        return [
          'statusCode' => 400,
          'message' => "invalid fields"
        ];
      }
      
      $registerActionResult = $this->action->perform(
        new RegisterInputDTO(
          name: $body['name'],
          email: new Email($body['email']), 
          password: new Password($body['password'])
        )
      );

      if($registerActionResult){
        return ['statusCode' => 200,'data' => [
          'id' => $registerActionResult->id,
          'name' => $registerActionResult->name,
          'email' => $registerActionResult->email,
          'password' => $registerActionResult->password,
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