<?php

namespace Mateusjatenee\Iugu\Tests\Fakes;

use Mateusjatenee\Iugu\Fakes\ChargeFake;
use Mateusjatenee\Iugu\Tests\TestCase;

class ChargeFakeTest extends TestCase
{
    public function setUp()
    {
        $this->fake = new ChargeFake;
    }

    /** @test */
    public function test_charge_method()
    {
        $response = $this->fake->generateToken(123, ['method' => 'credit_card']);

        $this->assertNotNull($response->id);
        $this->assertNotNull($response->getToken());
        $this->assertEquals('credit_card', $response->method);

        $this->fake->assertTokenWasGenerated(function ($token) {
            return $token['method'] == 'credit_card';
        });

    }

    /** @test
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessage The expected charge was not found.
     */
    public function it_does_not_find_a_charge()
    {
        $this->fake->assertCharged(function ($charge) {
            return $charge['email'] === 'mateus@weenside.com';
        });
    }

    /** @test
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessage The expected charge was not found.
     */
    public function it_asserts_a_charge_does_not_exist()
    {
        $this->fake->assertCharged(function ($charge) {
            return $charge['email'] === 'mateus@weenside.com';
        });
    }

    /** @test */
    public function it_asserts_a_charge_exists()
    {
        $data = [
            'token' => 123,
            'email' => 'mateus@weenside.com',
            'items' => [
                [
                    'description' => 'item 1',
                    'quantity' => 2,
                    'price_cents' => 1000,
                ],
            ],
        ];

        $this->fake->directCharge($data);

        $this->fake->assertCharged(function ($charge) {
            return $charge['email'] === 'mateus@weenside.com';
        });
    }
}
