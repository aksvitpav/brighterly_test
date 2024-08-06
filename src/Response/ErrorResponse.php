<?php

namespace App\Response;

class ErrorResponse extends Response
{
    public function __construct($message, $statusCode)
    {
        parent::__construct(
            [
                'error' => $message
            ],
            $statusCode
        );
    }

    public function send(): void
    {
        $this->setHeaders();
        echo json_encode($this->data);
        exit;
    }
}