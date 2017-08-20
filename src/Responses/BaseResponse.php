<?php

namespace Mateusjatenee\Iugu\Responses;

use Zttp\ZttpResponse;

class BaseResponse
{
    public function __construct($data)
    {
        $this->data = $data instanceof ZttpResponse ? $data->json() : $data;
    }

    public function __get($property)
    {
        return $this->data[$property] ?? null;
    }
}
