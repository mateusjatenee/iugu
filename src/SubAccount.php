<?php

namespace Mateusjatenee\Iugu;

use Mateusjatenee\Iugu\Resource;
use Mateusjatenee\Iugu\Responses\SubAccountResponse;

class SubAccount extends Resource
{
    private $iugu;

    /**
     * @param \Mateusjatenee\Iugu\Iugu $iugu
     */
    public function __construct($iugu)
    {
        $this->iugu = $iugu;
    }

    public function create($data)
    {
        $response = $this->iugu->client->post(
            $this->getEndpoint('marketplace.create_account'), $data
        );

        return new SubAccountResponse($response);
    }

}
