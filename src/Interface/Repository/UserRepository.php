<?php 
namespace Src\Interface\Repository;
interface UserRepository
{
  public function create($name, $email, $password);
  public function getByEmail($email);
}