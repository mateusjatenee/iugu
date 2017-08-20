<?php

namespace Mateusjatenee\Iugu;

use Illuminate\Support\Collection;
use Mateusjatenee\Iugu\Resource;
use Mateusjatenee\Iugu\Responses\TransferResponse;

class Transfer extends Resource
{
    private $iugu;

    public function __construct($iugu)
    {
        $this->iugu = $iugu;
    }

    public function transferTo($accountId, $amount)
    {
        $response = $this->iugu->client->post(
            $this->getEndpoint('transfers'), $this->buildTransferData($accountId, $amount)
        );

        return new TransferResponse($response);
    }

    public function find($id)
    {
        $response = $this->iugu->client->get(
            $this->getEndpoint('transfers') . '/' . $id
        );

        return new TransferResponse($response);
    }

    public function all($token = null)
    {
        if ($token) {
            $this->iugu->setToken($token);
        }

        $response = $this->iugu->client->get(
            $this->getEndpoint('transfers')
        );

        $data = $response;

        return TransferResponse::collection($data);
    }

    protected function buildTransferData($accountId, $amount)
    {
        return [
            'receiver_id' => $accountId,
            'amount_cents' => $amount,
        ];
    }

}
