<?php

namespace Mateusjatenee\Iugu;

class Resource
{
    public function getEndpoints()
    {
        return [
            'create_token' => 'https://api.iugu.com/v1/payment_token',
            'direct_charge' => 'https://api.iugu.com/v1/charge',
            'transfers' => 'https://api.iugu.com/v1/transfers',
        ];
    }

    public function getEndpoint($endpoint)
    {
        return $this->getEndpoints()[$endpoint];
    }
}
