<?php
declare(strict_types=1);
namespace Src\Action\Auth;

use Src\Dto\Auth\Login\LoginInputDTO;
use Src\Dto\Auth\Login\LoginOutputDTO;
use Src\Service\Auth\JwtService;
use Src\Service\Auth\PasswordService;
use Src\Interface\Service\ConfirmationCodeService;
use Src\Interface\Repository\UserRepository;
use Src\Interface\Feature\Login;
use Src\Interface\Service\EmailService;
use Exception;

class LoginAction implements Login
{
  public function __construct(
    private UserRepository $userRepository,
    private ConfirmationCodeService $confirmCodeService,
    private EmailService $emailService
  )
  {}
  
  public function perform(LoginInputDTO $data): LoginOutputDTO
  {
    [$email, $password] = [$data->email, $data->password];

    $userExists = $this->userRepository->getByEmail($email);
    if(!$userExists) throw new Exception("user not exists");

    $passwordMatches = PasswordService::comparePassword($userExists['password'], $password);
    if(!$passwordMatches) throw new Exception("invalid credentials");

    $useConfirmateCode = $_ENV['CONFIRMATE_CODE'];
    
    if($useConfirmateCode == 'true'){ // could validate if last login user is greater than 12 hours.
      // if true, send a confirmation code via email.
      $code = $this->confirmCodeService->generate($email);
      $this->emailService->sendConfirmationCodeEmail($email, $code);
      return new LoginOutputDTO(token: "", message: "the verification code has been sent to your email");
    }else{
      $jwtSignResult = JwtService::sign(['id' => $userExists['id'], 'email' => $userExists['email']]);
      return new LoginOutputDTO(token: $jwtSignResult['value']);
    }
    
  }
}