<?php
require_once("./routes.php");

use Src\Http\Response;
use Src\Http\Request;

$handleRequest = function(
  string $method = "GET",
  string $path = "/",
  array $body = [],
  array $headers = [],
  array $queryString = []
) use ($routesMap) {
  $routeMatched = matchRoutePath($path, $routesMap, $method);
  if(!$routeMatched){
    (new Response)->json(["message" => "not found"])->status(404)->end();
  }
  [$class, $classMethod] = explode("::", $routeMatched['handler']);
  return call_user_func(
    [$class, $classMethod], 
    new Request($body, $headers, $queryString), 
    new Response, 
    ...$routeMatched['params']
  );
};

function matchRoutePath(string $pathInfo, array $pathMap, string $method = "GET") {
  $handler = null;
  if($pathInfo == "/" || $pathInfo == ""){
    $handler = [
      'handler' => $pathMap["/"]["GET"],
      'params' => []
    ];
    return $handler;
  }
  
  // Itera sobre todas as rotas mapeadas
  foreach ($pathMap as $routeKey => $routeHandlers) {
    
    // Converte o padrão da rota para regex (substitui {param} por regex)
    $routePattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_-]+)', $routeKey);
    $routePattern = str_replace('/', '\/', $routePattern); // Para escapar as barras
    
    // Tenta combinar a rota com o path informado
    if (preg_match('/^' . $routePattern . '$/', $pathInfo, $matches)) {
        
        // Verifica se o método HTTP existe na rota
        if (isset($routeHandlers[$method])) {
            array_shift($matches); // Remove o primeiro item (a rota completa)
            
            // Captura o handler e adiciona os parâmetros capturados
            $handler = [
                'handler' => $routeHandlers[$method],
                'params' => $matches
            ];
            break;
        }
    }
  }
  return $handler;
}

function formatQueryStringToArray($queryString){
  $queryStringParts = explode("&",$queryString);
  $queryStringArray = [];
  if(!$queryStringParts) return $queryStringArray;
  foreach($queryStringParts as $part){
    if($part){
      list($key, $value) = explode("=", $part);
      $queryStringArray[$key] = $value;
    }
  }
  return $queryStringArray;
}