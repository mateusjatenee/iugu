<?php

namespace Mateusjatenee\Iugu\Fakes;

use Mateusjatenee\Iugu\Iugu;

class IuguFake
{
    public function charge()
    {
        return ChargeFake::getInstance($this);
    }

    public function transfers()
    {
        return TransferFake::getInstance($this);
    }

    public function subAccounts()
    {
        return SubAccountFake::getInstance($this);
    }

    public function marketplace()
    {
        return $this->subAccounts();
    }

    public function invoices()
    {
        return InvoiceFake::getInstance($this);
    }

    public function setToken($token)
    {
        return $this;
    }

    public function setClient()
    {
        return $this;
    }

}
