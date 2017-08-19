<?php

namespace Mateusjatenee\Iugu\Responses;

class ChargeResponse
{
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function __get($property)
    {
        return $this->data[$property] ?? null;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getInvoiceId()
    {
        return $this->invoice_id;
    }
}
