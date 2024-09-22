<?php 
require_once("./vendor/autoload.php");
require_once("./bootstrap.php");
date_default_timezone_set('America/Sao_Paulo');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();
// echo json_encode($_SERVER);
$method = $_SERVER["REQUEST_METHOD"];
$queryString = $_SERVER["QUERY_STRING"] ?? "";
$pathInfo = $_SERVER["REQUEST_URI"];
$headers = getallheaders();
$body = json_decode(file_get_contents("php://input"), true);
$queryStringArray = formatQueryStringToArray($queryString);

$handleRequest(
  method: (string)$method,
  path: (string) $pathInfo,
  body: (array)$body,
  headers: (array)$headers,
  queryString: (array)$queryStringArray
);

exit;