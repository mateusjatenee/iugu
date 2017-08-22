<?php

namespace Mateusjatenee\Iugu\Tests;

use Mateusjatenee\Iugu\Iugu;
use Mateusjatenee\Iugu\Tests\TestCase;

class SubAccountTest extends TestCase
{
    /** @test */
    public function it_creates_a_sub_account()
    {
        $stub = $this->getStub('marketplace_create_account.json');

        $data = [
            'name' => 'John Doe',
            'commission_percent' => 20,
        ];

        $this->iugu->setToken('foo');

        $subAccount = $this->iugu->subAccounts()->create($data);

        $this->assertResponseIsOk($subAccount);
        $this->assertEquals($stub['account_id'], $subAccount->account_id);
        $this->assertEquals($stub['name'], $subAccount->name);
        $this->assertEquals($stub['live_api_token'], $subAccount->live_api_token);
        $this->assertEquals($stub['user_token'], $subAccount->user_token);

        $this->assertEquals($data, $subAccount->requestData);
    }

}
