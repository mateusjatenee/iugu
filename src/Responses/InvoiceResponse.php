<?php

namespace Mateusjatenee\Iugu\Responses;

use Mateusjatenee\Iugu\Iugu;
use Mateusjatenee\Iugu\Responses\BaseResponse;

class InvoiceResponse extends BaseResponse
{
    /**
     * Refunds the current invoice.
     *
     * @return self
     */
    public function refund()
    {
        return Iugu::getInstance()->invoices()->refund($this);
    }
}
