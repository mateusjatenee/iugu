<?php

namespace Mateusjatenee\Iugu;

use Mateusjatenee\Iugu\Resource;
use Mateusjatenee\Iugu\Responses\ChargeResponse;
use Mateusjatenee\Iugu\Responses\TokenResponse;

class Charge extends Resource
{
    private $iugu;

    /**
     * @param \Mateusjatenee\Iugu\Iugu $iugu
     */
    public function __construct($iugu)
    {
        $this->iugu = $iugu;
    }

    /**
     * Generates a valid payment token.
     *
     * @param string $accountId
     * @param array $data
     * @return \Mateusjatenee\Iugu\Responses\TokenResponse
     */
    public function generateToken($accountId, $data)
    {
        $response = $this->iugu->client->post($this->getEndpoint('create_token'), ['account_id' => $accountId] + $data);

        return new TokenResponse($response);
    }

    /**
     * Performs a direct charge.
     *
     * @param array $data
     * @return \Mateusjatenee\Iugu\Responses\ChargeResponse
     */
    public function directCharge($data)
    {
        $response = $this->iugu->client->post(
            $this->getEndpoint('direct_charge'), $data
        );

        return new ChargeResponse($response);
    }
}
