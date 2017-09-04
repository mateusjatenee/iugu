<?php

namespace Mateusjatenee\Iugu\Responses;

use Mateusjatenee\Iugu\Responses\BaseResponse;

class SubAccountResponse extends BaseResponse
{
    /**
     * Get the unique sub account ID.
     *
     * @return string
     */
    public function getId()
    {
        return $this->data['account_id'] ?? $this->data['id'];
    }

    /**
     * Verifies the current sub account.
     *
     * @param array $data
     * @return self
     */
    public function verify($data)
    {
        return $this->getIugu()->subAccounts()->verify($this, $data);
    }

    /**
     * Requests an withdraw to the current sub account.
     *
     * @param int|float $amount
     * @return self
     */
    public function requestWithdraw($amount)
    {
        return $this->getIugu()->subAccounts()->requestWithdraw($this, $amount);
    }
}
