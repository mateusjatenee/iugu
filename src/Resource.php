<?php

namespace Mateusjatenee\Iugu;

use Illuminate\Support\Str;
use Mateusjatenee\Iugu\Iugu;

class Resource
{
    protected $endpoints = [
        'create_token' => 'https://api.iugu.com/v1/payment_token',
        'direct_charge' => 'https://api.iugu.com/v1/charge',
        'transfers' => 'https://api.iugu.com/v1/transfers/{id?}',
        'marketplace.create_account' => 'https://api.iugu.com/v1/marketplace/create_account',
        'accounts' => 'https://api.iugu.com/v1/accounts/{id?}',
        'accounts.verify' => 'https://api.iugu.com/v1/accounts/{id}/request_verification',
        'accounts.withdraw' => 'https://api.iugu.com/v1/accounts/{id}/request_withdraw',
        'invoices' => 'https://api.iugu.com/v1/invoices/{id?}',
        'invoices.refund' => 'https://api.iugu.com/v1/invoices/{id}/refund',
    ];

    public function getEndpoints()
    {
        if ($this->isInUnitTestMode()) {
            return $this->testingEndpoints();
        }

        return $this->endpoints;
    }

    public function getEndpoint($endpoint, $params = [])
    {
        $endpoint = $this->bindParams(
            $this->getEndpoints()[$endpoint], $params
        );

        if (Str::endsWith($endpoint, '/')) {
            $endpoint = Str::replaceLast('/', '', $endpoint);
        }

        return $endpoint;
    }

    protected function testingEndpoints()
    {
        return array_map(function ($endpoint) {
            return $this->url(Str::replaceFirst('https://api.iugu.com/v1/', '', $endpoint));
        }, $this->endpoints);
    }

    public function url($url)
    {
        return vsprintf('%s/%s', [
            'http://localhost:' . getenv('TEST_SERVER_PORT'),
            ltrim($url, '/'),
        ]);
    }

    protected function bindParams($endpoint, $params)
    {
        foreach ($params as $key => $param) {
            $endpoint = Str::replaceFirst('{' . $key . '}', $param, $endpoint);
            $endpoint = Str::replaceFirst('{' . $key . '?}', $param, $endpoint);
        }

        return $this->removeOptionalParams($endpoint);
    }

    protected function removeOptionalParams($endpoint)
    {
        return preg_replace('/{[\s\S]+?\?}/', '', $endpoint);
    }

    protected function isInUnitTestMode()
    {
        return Iugu::getInstance()->unitTesting;
    }
}
