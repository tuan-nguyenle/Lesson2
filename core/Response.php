<?php

namespace app\core;

/**
 * Class Respone
 * 
 * @package app\core
 */

class Response
{
    public function setStatusCode(int $statusCode)
    {
        http_response_code($statusCode);
    }
}
