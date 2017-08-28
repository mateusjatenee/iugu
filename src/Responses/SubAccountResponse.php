<?php

namespace Mateusjatenee\Iugu\Responses;

use Mateusjatenee\Iugu\Responses\BaseResponse;

class SubAccountResponse extends BaseResponse
{
    public function getId()
    {
        return $this->data['account_id'] ?? $this->data['id'];
    }

    public function verify($data)
    {
        return $this->getIugu()->subAccounts()->verify($this, $data);
    }

    public function requestWithdraw($amount)
    {
        return $this->getIugu()->subAccounts()->requestWithdraw($this, $amount);
    }
}
