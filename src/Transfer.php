<?php

namespace Mateusjatenee\Iugu;

use Illuminate\Support\Collection;
use Mateusjatenee\Iugu\Resource;
use Mateusjatenee\Iugu\Responses\TransferResponse;

class Transfer extends Resource
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
     * Transfers a certain amount to a given account.
     *
     * @param string $accountId
     * @param string $amount
     * @return \Mateusjatenee\Iugu\Responses\TransferResponse
     */
    public function transferTo($accountId, $amount)
    {
        $response = $this->iugu->client->post(
            $this->getEndpoint('transfers'), $this->buildTransferData($accountId, $amount)
        );

        return new TransferResponse($response);
    }

    /**
     * Finds a transfer by a given id.
     *
     * @param string $id
     * @return \Mateusjatenee\Iugu\Responses\TransferResponse
     */
    public function find($id)
    {
        $response = $this->iugu->client->get(
            $this->getEndpoint('transfers') . '/' . $id
        );

        return new TransferResponse($response);
    }

    /**
     * Gets all the transfers.
     *
     * @param string|null $token
     * @return \Illuminate\Support\Collection
     */
    public function all($token = null)
    {
        if ($token) {
            $this->iugu->setToken($token);
        }

        $response = $this->iugu->client->get(
            $this->getEndpoint('transfers')
        );

        return TransferResponse::collection($response);
    }

    /**
     * Builds the transfer array.
     *
     * @param string $accountId
     * @param string $amount
     * @return array
     */
    protected function buildTransferData($accountId, $amount)
    {
        return [
            'receiver_id' => $accountId,
            'amount_cents' => $amount,
        ];
    }

}
