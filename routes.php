<?php 

$routesMap = [
  "/" => [
    "GET" => "Src\RawController\WelcomeRawController::handle"
  ],
  "/login" => [
    "POST" => "Src\RawController\AuthRawController::handleLogin"
  ],
  "/confirmate-code" => [
    "POST" => "Src\RawController\AuthRawController::handleConfirmateCode"
  ],
  "/signup" => [
    "POST" => "Src\RawController\AuthRawController::handleSignup"
  ],
  "/task" => [
    "POST" => "Src\RawController\TaskRawController::handlePost",
    "GET" => "Src\RawController\TaskRawController::handleGetAll",
  ],
  "/task/{id}" => [
    // "GET" => "Src\RawController\TaskRawController::handleGet",
    "PUT" => "Src\RawController\TaskRawController::handlePut",
    "DELETE" => "Src\RawController\TaskRawController::handleDelete"
  ]
];