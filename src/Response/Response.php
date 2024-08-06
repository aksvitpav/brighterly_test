<?php

namespace App\Response;

abstract class Response
{
    public function __construct(
        protected $data,
        protected int $statusCode = 200
    ) {
    }

    abstract public function send();

    protected function setHeaders(): void
    {
        header('Content-Type: application/json');
        http_response_code($this->statusCode);
    }
}