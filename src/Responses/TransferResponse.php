<?php

namespace Mateusjatenee\Iugu\Responses;

use Mateusjatenee\Iugu\Responses\BaseResponse;

class TransferResponse extends BaseResponse
{
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
