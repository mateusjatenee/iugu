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
        $this->fake->create(['name' => 'foo']);

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
        $this->fake->find(123);

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
