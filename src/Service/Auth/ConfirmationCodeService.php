<?php
namespace Src\Service\Auth;

use Src\Interface\Repository\ConfirmationCodeRepository;
use Src\Interface\Service\ConfirmationCodeService as IConfirmationCodeService;

class ConfirmationCodeService implements IConfirmationCodeService
{

  public function __construct(private ConfirmationCodeRepository $confirmationCodeRepository)
  {}

  public function generate(string $identifier): string
  {
    try{
      $caracteres = '0123456789';
      $caracteresTamanho = strlen($caracteres);
      $code = '';
      for ($i = 0; $i < 6; $i++) {
          $code .= $caracteres[random_int(0, $caracteresTamanho - 1)];
      }
      $result = $this->confirmationCodeRepository->store($identifier, $code);
      return $code;
    }catch(\Exception $e){
      throw new Error($e->getMessage());
    }

  }

  public function validate($code, $identifier): bool
  {
    $identifierCodeStored = $this->confirmationCodeRepository->getByIdentifier($identifier);
    return $identifierCodeStored === $code;
  }

  public function destroy(string $identifier)
  {
    return $this->confirmationCodeRepository->delete($identifier);
  }

}