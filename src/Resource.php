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
            'accounts' => 'https://api.iugu.com/v1/accounts',
            'accounts.verify' => 'https://api.iugu.com/v1/accounts/{id}/request_verification',
            'accounts.withdraw' => 'https://api.iugu.com/v1/accounts/{id}/request_withdraw',
        ];
    }

    public function getEndpoint($endpoint, $params = [])
    {
        $endpoint = $this->getEndpoints()[$endpoint];

        return $this->setParameters($endpoint, $params);
    }

    protected function testingEndpoints()
    {
        return [
            'create_token' => $this->url('/payment_token'),
            'direct_charge' => $this->url('/charge'),
            'transfers' => $this->url('/transfers'),
            'marketplace.create_account' => $this->url('/marketplace/create_account'),
            'accounts' => $this->url('/accounts'),
            'accounts.verify' => $this->url('/accounts/{id}/request_verification'),
            'accounts.withdraw' => $this->url('/accounts/{id}/request_withdraw'),

        ];
    }

    public function url($url)
    {
        return vsprintf('%s/%s', [
            'http://localhost:' . getenv('TEST_SERVER_PORT'),
            ltrim($url, '/'),
        ]);
    }

    protected function setParameters($endpoint, $params)
    {
        foreach ($params as $key => $param) {
            $endpoint = str_replace('{' . $key . '}', $param, $endpoint);
        }

        return $endpoint;
    }
}
