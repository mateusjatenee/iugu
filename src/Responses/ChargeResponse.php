<?php

namespace Mateusjatenee\Iugu\Responses;

use Mateusjatenee\Iugu\Responses\BaseResponse;

class ChargeResponse extends BaseResponse
{
    /**
     * Gets the charge message.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Geths the charge invoice ID.
     *
     * @return string
     */
    public function getInvoiceId()
    {
        return $this->invoice_id;
    }
}
