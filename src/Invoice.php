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

    /**
     * Creates a new invoice.
     *
     * @param  array $data
     * @return \Mateusjatenee\Iugu\Responses\InvoiceResponse
     */
    public function create($data)
    {
        $response = $this->iugu->client->post(
            $this->getEndpoint('invoices'), $data
        );

        return $response->to(InvoiceResponse::class);
    }

    /**
     * Finds an invoice by it's ID.
     *
     * @param  string $id
     * @return \Mateusjatenee\Iugu\Responses\InvoiceResponse
     */
    public function find($id)
    {
        $response = $this->iugu->client->get(
            $this->getEndpoint('invoices', ['id' => $id])
        );

        return $response->to(InvoiceResponse::class);
    }

    /**
     * Refunds an invoice.
     *
     * @param  \Mateusjatenee\Iugu\Responses\InvoiceResponse|string $id
     * @return \Mateusjatenee\Iugu\Responses\InvoiceResponse
     */
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
}
