<?php

namespace Mateusjatenee\Iugu\Responses;

use Mateusjatenee\Iugu\Responses\BaseResponse;

class ChargeResponse extends BaseResponse
{
    public function getMessage()
    {
        return $this->message;
    }

    public function getInvoiceId()
    {
        return $this->invoice_id;
    }
}
