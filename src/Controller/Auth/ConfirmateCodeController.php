<?php 
declare(strict_types=1);
namespace Src\Controller\Auth;
use Src\Action\Auth\RegisterAction;
use Src\Dto\Auth\ConfirmateCode\ConfirmateCodeInputDTO;
use Src\ObjectValue\Auth\Email;
use Src\ObjectValue\Auth\Password;
use Src\Interface\Feature\ConfirmateCode;
use Exception;

class ConfirmateCodeController 
{
  public function __construct(private ConfirmateCode $action)
  {}

  public function handle(array $body): array
  {
    try{
      if(!count($body) || !isset($body['email']) || !isset($body['code'])){
        return ['statusCode' => 400,'message' => "invalid fields"];
      }
      $actionResult = $this->action->perform(
        new ConfirmateCodeInputDTO(
          email: new Email($body['email']),
          code: (string) $body['code']
        )
      );
      if($actionResult->token !== ""){
        return ['statusCode' => 200,'data' => ['token' => $actionResult->token]];
      }
      return ['statusCode' => 200,'data' => ['message' => $actionResult->message]];
      
    }catch(\Exception $e){
      throw new Exception($e->getMessage());
    }
  }
}