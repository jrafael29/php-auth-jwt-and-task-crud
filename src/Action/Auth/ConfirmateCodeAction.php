<?php
declare(strict_types=1);
namespace Src\Action\Auth;

use Src\Dto\Auth\ConfirmateCode\ConfirmateCodeInputDTO;
use Src\Dto\Auth\ConfirmateCode\ConfirmateCodeOutputDTO;
use Src\Service\Auth\JwtService;
use Src\Service\Auth\PasswordService;
use Src\Interface\Service\ConfirmationCodeService;
use Src\Interface\Feature\ConfirmateCode;
use Src\Interface\Repository\UserRepository;
use Exception;

class ConfirmateCodeAction implements ConfirmateCode
{
  public function __construct(
    private UserRepository $userRepository,
    private ConfirmationCodeService $confirmCodeService,
  )
  {}
  
  public function perform(ConfirmateCodeInputDTO $data): ConfirmateCodeOutputDTO
  {
    try{
      [$email, $code] = [$data->email, $data->code];

      $userExists = $this->userRepository->getByEmail($email);
      if(!$userExists) throw new Exception("user not exists");
  
      // if true, send a confirmation code via email.
      $codeIsValid = $this->confirmCodeService->validate($code, $email);
      if(!$codeIsValid) throw new Exception("invalid code");

      $jwtSignResult = JwtService::sign(['id' => $userExists['id'], 'email' => $userExists['email']]);

      // remove code;
      $this->confirmCodeService->destroy($email);

      return new ConfirmateCodeOutputDTO(token: $jwtSignResult['value']);
    }catch(\Exception $e){
      throw new Exception($e->getMessage());
    }
    
  }
}