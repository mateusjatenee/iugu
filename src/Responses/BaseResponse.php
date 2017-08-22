<?php

namespace Mateusjatenee\Iugu\Responses;

use Zttp\ZttpResponse;

class BaseResponse
{
    public function __construct($data, $response = null)
    {
        $this->data = $data instanceof ZttpResponse ? $data->json() : $data;
        $this->response = $this->getResponse($data, $response);
    }

    public function __get($property)
    {
        return $this->data[$property] ?? null;
    }

    public function isOk()
    {
        return $this->response->isOk();
    }

    protected function getResponse($data, $response)
    {
        if ($response) {
            return $response;
        }

        return $data instanceof ZttpResponse ? $data : null;
    }
}
