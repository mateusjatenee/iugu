<?php

namespace Mateusjatenee\Iugu;

use Mateusjatenee\Iugu\Resource;
use Mateusjatenee\Iugu\Responses\ChargeResponse;
use Mateusjatenee\Iugu\Responses\TokenResponse;

class Charge extends Resource
{
    private $iugu;

    public function __construct($iugu)
    {
        $this->iugu = $iugu;
    }

    public function generateToken($accountId, $data)
    {
        $request = $this->iugu->client->post($this->getEndpoint('create_token'), ['account_id' => $accountId] + $data);

        return new TokenResponse($request->json());
    }

    public function directCharge($data)
    {
        $request = $this->iugu->client->post(
            $this->getEndpoint('direct_charge'), $data
        );

        return new ChargeResponse($request->json());
    }
}
