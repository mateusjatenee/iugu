<?php

namespace Mateusjatenee\Iugu;

use Mateusjatenee\Iugu\Iugu;
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
        $response = $this->iugu->client->post($this->getEndpoint('create_token'), $this->buildTokenData($accountId, $data));

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

    protected function buildTokenData($accountId, $data)
    {
        $data = array_merge($data, ['account_id' => $accountId]);

        return $data;
    }
}
