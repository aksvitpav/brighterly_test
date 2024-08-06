<?php

namespace App\Response;

class JsonResponse extends Response
{
    public function send(): void
    {
        $this->setHeaders();
        echo json_encode($this->data);
        exit;
    }
}