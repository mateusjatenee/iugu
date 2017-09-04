<?php

namespace Mateusjatenee\Iugu\Tests\Fakes;

use Mateusjatenee\Iugu\Fakes\SubAccountFake;
use Mateusjatenee\Iugu\Tests\TestCase;

class SubAccountFakeTest extends TestCase
{
    public function setUp()
    {
        $this->fake = new SubAccountFake;
    }

    /** @test */
    public function test_create_method()
    {
        $response = $this->fake->create(['name' => 'foo']);

        $this->assertNotNull($response->account_id);
        $this->assertEquals($response->account_id, $response->getId());

        $array = $response->toArray();

        $this->assertArrayHasKey('account_id', $array);
        $this->assertArrayHasKey('name', $array);
        $this->assertArrayHasKey('live_api_token', $array);
        $this->assertArrayHasKey('test_api_token', $array);
        $this->assertArrayHasKey('user_token', $array);

        $this->fake->assertCreated(function ($account) {
            return $account['name'] === 'foo';
        });
    }

    /** @test
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessage The expected account was not created.
     */
    public function test_assert_created_fails()
    {
        $this->fake->assertCreated(function ($account) {
            return $account['name'] === 'foo';
        });
    }

    /** @test */
    public function test_assert_found()
    {
        $response = $this->fake->find(123);

        $this->assertNotNull($response->id);
        $this->assertEquals($response->id, $response->getId());

        $array = $response->toArray();

        $this->assertArrayHasKey('name', $array);
        $this->assertArrayHasKey('created_at', $array);
        $this->assertArrayHasKey('updated_at', $array);
        $this->assertArrayHasKey('can_receive?', $array);
        $this->assertArrayHasKey('is_verified?', $array);
        $this->assertArrayHasKey('informations', $array);
        $this->assertArrayHasKey('balance', $array);
        $this->assertArrayHasKey('balance_available_for_withdraw', $array);
        $this->assertArrayHasKey('receivable_balance', $array);

        $this->fake->assertFound(123);
    }

    /** @test
     * @expectedException PHPUnit\Framework\ExpectationFailedException
     * @expectedExceptionMessage The expected account with id 123 was not searched for.
     */
    public function test_assert_found_fails()
    {
        $this->fake->assertFound(123);
    }
}
