<?php 
namespace Src\Interface;
interface UserRepository
{
  public function create($name, $email, $password);
  public function getByEmail($email);
}