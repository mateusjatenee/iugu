<?php

namespace Mateusjatenee\Iugu\Tests\Fakes;

use Mateusjatenee\Iugu\Fakes\ChargeFake;
use Mateusjatenee\Iugu\Fakes\InvoiceFake;
use Mateusjatenee\Iugu\Fakes\IuguFake;
use Mateusjatenee\Iugu\Fakes\SubAccountFake;
use Mateusjatenee\Iugu\Fakes\TransferFake;
use Mateusjatenee\Iugu\Tests\TestCase;

class IuguFakeTest extends TestCase
{
    public function setUp()
    {
        $this->fake = IuguFake::getInstance();
    }

    /** @test */
    public function it_returns_fake_instances()
    {
        $charge = $this->fake->charge();
        $transfers = $this->fake->transfers();
        $subAccounts = $this->fake->subAccounts();
        $marketplace = $this->fake->marketplace();
        $invoices = $this->fake->invoices();

        $this->assertInstanceOf(ChargeFake::class, $charge);
        $this->assertInstanceOf(TransferFake::class, $transfers);
        $this->assertInstanceOf(SubAccountFake::class, $subAccounts);
        $this->assertInstanceOf(SubAccountFake::class, $marketplace);
        $this->assertInstanceOf(InvoiceFake::class, $invoices);

        $this->assertSame($charge, $this->fake->charge());
        $this->assertSame($transfers, $this->fake->transfers());
        $this->assertSame($subAccounts, $this->fake->subAccounts());
        $this->assertSame($marketplace, $this->fake->marketplace());
        $this->assertSame($invoices, $this->fake->invoices());
    }
}
