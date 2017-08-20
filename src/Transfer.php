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

        return new TransferResponse($response->json());
    }

    public function all()
    {
        $response = $this->iugu->client->get(
            $this->getEndpoint('transfers')
        );

        $data = $response->json();

        return [
            'sent' => (new Collection($data['sent']))->map(function ($item) {
                return new TransferResponse($item);
            }),
            'received' => (new Collection($data['received']))->map(function ($item) {
                return new TransferResponse($item);
            }),
        ];
    }

    protected function buildTransferData($accountId, $amount)
    {
        return [
            'receiver_id' => $accountId,
            'amount_cents' => $amount,
        ];
    }

}
