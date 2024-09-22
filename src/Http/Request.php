<?php 

namespace Src\Http;

class Request 
{
  public function __construct(
    private array $body,
    private array $headers,
    private array $queryString
  )
  {}

  public function getBody()
  {
    return $this->body;
  }

  public function getHeaders()
  {
    return $this->headers;
  }

  public function getQueryString()
  {
    return $this->queryString;
  }
}