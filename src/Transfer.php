<?php

namespace Mateusjatenee\Iugu;

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
            $this->getEndpoint('money_transfer'), $this->buildTransferData($accountId, $amount)
        );

        return new TransferResponse($response->json());
    }

    protected function buildTransferData($accountId, $amount)
    {
        return [
            'receiver_id' => $accountId,
            'amount_cents' => $amount,
        ];
    }

}
