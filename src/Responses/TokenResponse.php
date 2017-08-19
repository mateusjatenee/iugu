<?php

namespace Mateusjatenee\Iugu\Responses;

class TokenResponse
{
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function __get($property)
    {
        return $this->data[$property] ?? null;
    }

    public function getToken()
    {
        return $this->id;
    }
}
