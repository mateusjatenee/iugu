<?php

namespace Mateusjatenee\Iugu;

use Mateusjatenee\Iugu\Resource;
use Mateusjatenee\Iugu\Responses\InvoiceResponse;

class Invoice extends Resource
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
            $this->getEndpoint('invoices'), $data
        );

        return $response->to(InvoiceResponse::class);
    }

    public function find($id)
    {
        $response = $this->iugu->client->get(
            $this->getEndpoint('invoices', ['id' => $id])
        );

        return $response->to(InvoiceResponse::class);
    }

    public function refund($id)
    {
        if ($id instanceof InvoiceResponse) {
            $id = $id->id;
        }

        $response = $this->iugu->client->post(
            $this->getEndpoint('invoices.refund', ['id' => $id])
        );

        return $response->to(InvoiceResponse::class);
    }

    public function requestWithdraw($id, $amount)
    {
        if ($id instanceof InvoiceResponse) {
            $id = $id->id;
        }

        $response = $this->iugu->client->post(
            $this->getEndpoint('accounts.withdraw', ['id' => $id]), ['amount' => $amount]
        );

        return $response->to(InvoiceResponse::class);
    }

}
