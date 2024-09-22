<?php 

namespace Src\RawController;

use Src\Http\Request;
use Src\Http\Response;

class WelcomeRawController 
{

  public static function handle(Request $request, Response $response)
  {
    $response->json(["hello" => "world"])->end();
  }

}