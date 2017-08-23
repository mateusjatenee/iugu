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
        $this->fake = new IuguFake;
    }

    /** @test */
    public function it_returns_fake_instances()
    {
        $this->assertInstanceOf(ChargeFake::class, $this->fake->charge());
        $this->assertInstanceOf(TransferFake::class, $this->fake->transfers());
        $this->assertInstanceOf(SubAccountFake::class, $this->fake->subAccounts());
        $this->assertInstanceOf(SubAccountFake::class, $this->fake->marketplace());
        $this->assertInstanceOf(InvoiceFake::class, $this->fake->invoices());
    }
}
