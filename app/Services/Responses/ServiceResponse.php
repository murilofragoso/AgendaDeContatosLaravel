<?php

namespace App\Services\Responses;

class ServiceResponse
{
    public $message;
    public $statusCode;
    public $data;

    public function __construct(
        string $message,
        int $statusCode = 200,
        $data = null
    ) {
        $this->message = $message;
        $this->statusCode = $statusCode;
        $this->data = $data;
    }
}
