<?php 
declare(strict_types=1);
namespace Src\Controller\Auth;
use Src\Action\Auth\RegisterAction;
use Src\Dto\Auth\Login\LoginInputDTO;
use Src\ObjectValue\Auth\Email;
use Src\ObjectValue\Auth\Password;
use Src\Interface\Feature\Login;
use Exception;

class LoginController 
{
  public function __construct(private Login $action)
  {}

  public function handle(array $body): array
  {
    try{
      if(!count($body) || !isset($body['email']) || !isset($body['password'])){
        return ['statusCode' => 400,'message' => "invalid fields"];
      }
      $loginActionResult = $this->action->perform(
        new LoginInputDTO(
          email: new Email($body['email']),
          password: new Password($body['password'])
        )
      );
      if($loginActionResult->token !== ""){
        return ['statusCode' => 200,'data' => ['token' => $loginActionResult->token]];
      }else{
        return ['statusCode' => 200,'data' => ['message' => $loginActionResult->message]];

      }
    }catch(\Exception $e){
      throw new Exception($e->getMessage());
    }
  }
}