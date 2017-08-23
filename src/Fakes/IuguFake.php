<?php

namespace Mateusjatenee\Iugu\Fakes;

use Mateusjatenee\Iugu\Iugu;

class IuguFake
{
    public function charge()
    {
        return new ChargeFake($this);
    }

    public function transfers()
    {
        return new TransferFake($this);
    }

    public function subAccounts()
    {
        return new SubAccountFake($this);
    }

    public function marketplace()
    {
        return $this->subAccounts();
    }

    public function invoices()
    {
        return new InvoiceFake($this);
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
