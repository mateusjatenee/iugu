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

    public function find($id)
    {
        $response = $this->iugu->client->get(
            $this->getEndpoint('accounts') . '/' . $id
        );

        return new SubAccountResponse($response);
    }

    public function verify($id, $data)
    {
        if ($id instanceof SubAccountResponse) {
            $id = $id->id;
        }

        $response = $this->iugu->client->post(
            $this->getEndpoint('accounts.verify', ['id' => $id]), $data
        );

        return new SubAccountResponse($response);
    }

}
