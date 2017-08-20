<?php

namespace Mateusjatenee\Iugu;

class Resource
{
    public function getEndpoints()
    {
        if (getenv('IUGU_TESTING')) {
            return $this->testingEndpoints();
        }

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

    protected function testingEndpoints()
    {
        return [
            'create_token' => $this->url('/payment_token'),
            'direct_charge' => $this->url('/charge'),
            'transfers' => $this->url('/transfers'),
        ];
    }

    public function url($url)
    {
        return vsprintf('%s/%s', [
            'http://localhost:' . getenv('TEST_SERVER_PORT'),
            ltrim($url, '/'),
        ]);
    }
}
