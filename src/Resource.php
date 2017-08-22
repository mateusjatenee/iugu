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
            'marketplace.create_account' => 'https://api.iugu.com/v1/marketplace/create_account',
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
            'marketplace.create_account' => $this->url('/marketplace/create_account'),
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
