<?php

namespace Mateusjatenee\Iugu\Fakes;

use Mateusjatenee\Iugu\Fakes\ChargeFake;
use Mateusjatenee\Iugu\Fakes\InvoiceFake;
use Mateusjatenee\Iugu\Fakes\SubAccountFake;
use Mateusjatenee\Iugu\Fakes\TransferFake;
use Mateusjatenee\Iugu\Iugu;
use Mateusjatenee\Iugu\Singleton;

class IuguFake
{
    use Singleton;

    static $instance;

    public function __construct()
    {
        $this->charge = new ChargeFake($this);
        $this->transfer = new TransferFake($this);
        $this->subAccount = new SubAccountFake($this);
        $this->invoice = new InvoiceFake($this);
    }

    public function charge($data = null)
    {
        if ($data) {
            return $this->charge->directCharge($data);
        }

        return $this->charge;
    }

    public function transfers()
    {
        return $this->transfer;
    }

    public function subAccounts()
    {
        return $this->subAccount;
    }

    public function marketplace()
    {
        return $this->subAccounts();
    }

    public function invoices()
    {
        return $this->invoice;
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
