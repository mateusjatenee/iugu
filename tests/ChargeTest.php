<?php

namespace Mateusjatenee\Iugu\Tests;

use Mateusjatenee\Iugu\Iugu;
use Mateusjatenee\Iugu\Tests\TestCase;

class ChargeTest extends TestCase
{
    /** @test */
    public function it_generates_a_token()
    {
        $stub = $this->getStub('token_create_response.json');

        $url = 'https://api.iugu.com/v1/payment_token';

        $data = [
            'method' => 'credit_card',
            'data' => [
                'number' => 4111111111111111,
                'verification_value' => 123,
                'first_name' => 'Mateus',
                'last_name' => 'Guimarães',
                'month' => '01',
                'year' => '2020',
            ],
        ];

        $this->iugu->setToken('foo');

        $response = $this->iugu->charge()->generateToken(123, $data);

        $this->assertResponseIsOk($response);
        $this->assertEquals($response->getToken(), $stub['id']);
        $this->assertEquals($response->id, $stub['id']);
        $this->assertEquals($data + ['account_id' => 123], $response->requestData);
    }

    /** @test */
    public function it_charges_someone()
    {
        $stub = $this->getStub('charge.json');

        $url = 'https://api.iugu.com/v1/charge';

        $data = [
            'token' => '123',
            'email' => 'foo@bar.com',
            'items' => [
                [
                    'description' => 'item 1',
                    'quantity' => 2,
                    'price_cents' => 1000,
                ],
            ],
        ];

        $response = $this->iugu->charge($data);

        $this->assertResponseIsOk($response);
        $this->assertEquals($response->getMessage(), $stub['message']);
        $this->assertEquals($response->getInvoiceId(), $stub['invoice_id']);
        $this->assertEquals($data, $response->requestData);
    }
}
