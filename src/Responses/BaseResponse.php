<?php

namespace Mateusjatenee\Iugu\Responses;

class BaseResponse
{
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function __get($property)
    {
        return $this->data[$property] ?? null;
    }
}
