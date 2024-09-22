<?php 

namespace Src\Http;

class Response 
{
  private mixed $response;
  private int $status = 200;

  public function json(array $data)
  {
    header('Content-Type: application/json');
    $this->response = $data;
    return $this;
  }

  public function write(string $data)
  {
    $this->response = $data;
    return $this;
  }

  public function end()
  {
    http_response_code($this->status);
    if(gettype($this->response) == 'array'){
      echo json_encode($this->response);
    }else{
      echo $this->response;
    }
    exit;
  }

  public function status(int $status)
  {
    $this->status = $status;
    return $this;
  }
}