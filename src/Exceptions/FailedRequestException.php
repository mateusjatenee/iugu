<?php

namespace Mateusjatenee\Iugu\Exceptions;

class FailedRequestException extends \Exception
{
    private $response;

    public function __construct($response)
    {
        $this->response = $response;
    }

    public function isOk()
    {
        return $this->response->isOk();
    }

    public function getErrors()
    {
        return $this->response->json()['errors'];
    }
}
