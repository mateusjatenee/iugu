<?php

namespace Mateusjatenee\Iugu\Testing\Integration;

use Mateusjatenee\Iugu\Iugu;
use Mateusjatenee\Iugu\Tests\IntegrationTestCase;

class ChargeTest extends IntegrationTestCase
{

    /** @test */
    public function it_makes_a_charge()
    {
        $iugu = new Iugu(getenv('API_KEY'));

        $iugu->setTesting(true);

        $charge = $iugu->charge([
            'token' => $this->generateToken()->id,
            'email' => 'teste@superteste.abc',
            'items' => [
                'description' => 'Item Teste',
                'quantity' => '1',
                'price_cents' => '100',
            ],
        ]);

        $this->assertNotNull($charge);
        $this->assertNotNull($charge->invoice_id);
        $this->assertEquals($charge->success, true);
        $this->assertEquals($charge->message, 'Autorizado');
        $this->assertNotNull($charge->url);
        $this->assertNotNull($charge->pdf);
    }

    public function generateToken()
    {
        $token = Iugu::getInstance()->charge()->generateToken(getenv('ACCOUNT_ID'), [
            'method' => 'credit_card',
            'data' => [
                'number' => '4111111111111111',
                'verification_value' => '123',
                'first_name' => 'Mateus',
                'last_name' => 'Guimarães',
                'month' => '11',
                'year' => '2024',
            ],
        ]);

        return $token;
    }
}
