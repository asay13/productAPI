<?php

namespace Views;

class JsonResponse
{
    public function setResponse(mixed $message, $status = 200)
    {
        header('Content-Type: application/json');
        http_response_code($status);
        return json_encode($message);
    }
}