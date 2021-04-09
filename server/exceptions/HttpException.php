<?php

class HttpException extends Exception
{
    private int $httpCode;

    public function getHttpCode() 
    {
        return $this->httpCode;
    }

    public function __construct($msg, $httpCode)
    {
        parent::__construct($msg);
        $this->httpCode = $httpCode;
    }
}