<?php

namespace Mateusjatenee\Iugu\Responses;

class TransferResponse
{
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function __get($property)
    {
        return $this->data[$property] ?? null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getAmountInCents()
    {
        return $this->amount_cents;
    }

    public function getLocalizedAmount()
    {
        return $this->amount_localized;
    }

    public function getReceiver()
    {
        return $this->receiver;
    }
}
