<?php

namespace Mateusjatenee\Iugu\Tests;

use Mateusjatenee\Iugu\Iugu;
use Mateusjatenee\Iugu\Tests\TestCase;

class InvoiceTest extends TestCase
{
    /** @test */
    public function it_finds_an_invoice()
    {
        $stub = $this->getStub('find_invoice_response.json');

        $invoice = $this->iugu->invoices()->find(123);

        $this->assertEquals($stub['id'], $invoice->id);
        $this->assertEquals($stub['items'], $invoice->items);
        $this->assertEquals($stub['bank_slip'], $invoice->bank_slip);
        $this->assertEquals(123, $invoice->params['id']);
    }

    /** @test */
    public function it_creates_an_invoice()
    {
        $stub = $this->getStub('create_invoice_response.json');

        $data = [
            'email' => 'foo@bar.com',
            'due_date' => '2020-01-01',
            'items' => [
                [
                    'description' => 'Software services',
                    'quantity' => 10,
                    'price_cents' => 10000,
                ],
            ],
        ];

        $invoice = $this->iugu->invoices()->create($data);

        $this->assertEquals($stub['id'], $invoice->id);
        $this->assertEquals($stub['due_date'], $invoice->due_date);

        $this->assertEquals($data, $invoice->requestData);
    }

    /** @test */
    public function it_refunds_an_invoice()
    {
        $stub = $this->getStub('refund_invoice_response.json');

        $foundInvoice = $this->iugu->invoices()->find(123);

        $invoice = $foundInvoice->refund();

        $this->assertEquals($stub['id'], $invoice->id);
        $this->assertEquals('refunded', $invoice->status);

        $this->assertEquals($foundInvoice->id, $invoice->params['id']);
    }

}
