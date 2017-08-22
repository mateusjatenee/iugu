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

    /** @test */
    public function it_finds_a_sub_account()
    {
        $stub = $this->getStub('marketplace_123_account.json');

        $this->iugu->setToken('foo');

        $subAccount = $this->iugu->subAccounts()->find(456);

        $this->assertResponseIsOk($subAccount);
        $this->assertEquals($stub['id'], $subAccount->id);
        $this->assertEquals($stub['name'], $subAccount->name);
        $this->assertEquals($stub['created_at'], $subAccount->created_at);

        $this->assertEquals(456, $subAccount->params['id']);
    }

    /** @test */
    public function it_verifies_a_sub_account()
    {
        $stub = $this->getStub('marketplace_verify_account.json');

        $this->iugu->setToken('foo');

        $subAccount = $this->iugu->subAccounts()->find(456);

        $data = $this->getVerificationData();

        // $verification = $this->iugu->subAccounts()->verify($subAccount, $data);
        $verification = $subAccount->verify($data);

        $this->assertResponseIsOk($verification);
        $this->assertEquals($stub['account_id'], $verification->account_id);
        $this->assertEquals($data, $verification->requestData);

        $this->assertEquals($subAccount->id, $verification->params['id']);
    }

    /** @test */
    public function it_verifies_an_account_by_its_id()
    {
        $stub = $this->getStub('marketplace_verify_account.json');

        $this->iugu->setToken('foo');

        $subAccount = $this->iugu->subAccounts()->find(456);

        $data = $this->getVerificationData();

        $verification = $this->iugu->subAccounts()->verify($subAccount->id, $data);

        $this->assertResponseIsOk($verification);
        $this->assertEquals($stub['account_id'], $verification->account_id);
        $this->assertEquals($data, $verification->requestData);

        $this->assertEquals($subAccount->id, $verification->params['id']);
    }

    /** @test */
    public function it_requests_withdraw()
    {
        $stub = $this->getStub('marketplace_account_request_withdraw.json');

        $this->iugu->setToken('foo');

        $subAccount = $this->iugu->subAccounts()->find(456);

        $withdraw = $subAccount->requestWithdraw(500);

        $this->assertResponseIsOk($withdraw);
        $this->assertEquals(500.0, $withdraw->requestData['amount']);

        $this->assertEquals($subAccount->id, $withdraw->params['id']);
    }

    protected function getVerificationData()
    {
        return [
            'data' => [
                'price_range' => 'Até R$ 100,00',
                'physical_products' => false,
                'business_type' => 'Internet',
                'person_type' => 'Pessoa Física',
                'automatic_transfer' => false,
                'cpf' => '000.000.000.-25',
                'name' => 'Mateus Guimarães',
                'address' => 'Rua Arandu, 205',
                'cep' => '01416001',
                'city' => 'São Paulo',
                'state' => 'São Paulo',
                'telephone' => '119980339811',
                'bank' => 'Itaú',
                'bank_ag' => '4444',
                'bank_cc' => '409213',
                'account_type' => 'Corrente',
            ],
        ];
    }

}
