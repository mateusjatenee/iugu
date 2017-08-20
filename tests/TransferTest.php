<?php

namespace Mateusjatenee\Iugu\Tests;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Mateusjatenee\Iugu\Iugu;
use Mateusjatenee\Iugu\Responses\TransferResponse;
use Mateusjatenee\Iugu\Tests\TestCase;
use Zttp\ZttpResponse;

class TransferTest extends TestCase
{
    /** @test */
    public function it_transfers_money_to_someone()
    {
        $stub = $this->getStub('responses/transfer_response.json');

        $url = 'https://api.iugu.com/v1/transfers';

        $data = [
            'account_id' => 123,
            'amount_cents' => 10000,
        ];

        $this->client->shouldReceive('withBasicAuth')->with('foo', '')->once()
            ->andReturnSelf()
            ->shouldReceive('post')
            ->andReturn(new ZttpResponse(
                \Mockery::mock(new Response)->shouldReceive('getBody')->andReturn(json_encode($stub))->getMock()
            ));

        $this->iugu->setToken('foo');

        $transfer = $this->iugu->transfers()->transferTo(123, 10000);

        $this->assertEquals($stub['id'], $transfer->getId());
        $this->assertEquals($stub['created_at'], $transfer->getCreatedAt());
        $this->assertEquals($stub['amount_cents'], $transfer->getAmountInCents());
        $this->assertEquals($stub['amount_localized'], $transfer->getLocalizedAmount());
        $this->assertEquals($stub['receiver'], $transfer->getReceiver());
    }

    /** @test */
    public function it_finds_a_transference()
    {
        $stub = $this->getStub('responses/transfer_response.json');

        $url = 'https://api.iugu.com/v1/transfers/abc123';

        $this->client->shouldReceive('withBasicAuth')->with('foo', '')->once()
            ->andReturnSelf()
            ->shouldReceive('get')->with($url)
            ->andReturn(new ZttpResponse(
                \Mockery::mock(new Response)->shouldReceive('getBody')->andReturn(json_encode($stub))->getMock()
            ));

        $this->iugu->setToken('foo');

        $transfer = $this->iugu->transfers()->find('abc123');

        $this->assertEquals($stub['id'], $transfer->getId());
        $this->assertEquals($stub['created_at'], $transfer->getCreatedAt());
        $this->assertEquals($stub['amount_cents'], $transfer->getAmountInCents());
        $this->assertEquals($stub['amount_localized'], $transfer->getLocalizedAmount());
        $this->assertEquals($stub['receiver'], $transfer->getReceiver());
    }

    /** @test */
    public function it_gets_all_transferences_of_an_account()
    {
        $stub = $this->getStub('responses/all_transfers_response.json');

        $url = 'https://api.iugu.com/v1/transfers';

        $this->client->shouldReceive('withBasicAuth')->with('foo', '')->once()
            ->andReturnSelf()
            ->shouldReceive('get')
            ->andReturn(new ZttpResponse(
                \Mockery::mock(new Response)->shouldReceive('getBody')->andReturn(json_encode($stub))->getMock()
            ));

        $this->iugu->setToken('foo');

        $transfer = $this->iugu->transfers()->all();

        $sent = $transfer['sent'];
        $received = $transfer['received'];

        $this->assertInstanceOf(Collection::class, $sent);
        $this->assertInstanceOf(Collection::class, $received);

        foreach ($sent as $item) {
            $this->assertInstanceOf(TransferResponse::class, $item);
        }

        foreach ($received as $item) {
            $this->assertInstanceOf(TransferResponse::class, $item);
        }

        $sent = $sent->first();

        $this->assertEquals($stub['sent'][0]['id'], $sent->getId());
        $this->assertEquals($stub['sent'][0]['created_at'], $sent->getCreatedAt());
        $this->assertEquals($stub['sent'][0]['amount_cents'], $sent->getAmountInCents());
        $this->assertEquals($stub['sent'][0]['amount_localized'], $sent->getLocalizedAmount());
        $this->assertEquals($stub['sent'][0]['receiver'], $sent->getReceiver());

        $received = $received->first();

        $this->assertEquals($stub['received'][0]['id'], $received->getId());
        $this->assertEquals($stub['received'][0]['created_at'], $received->getCreatedAt());
        $this->assertEquals($stub['received'][0]['amount_cents'], $received->getAmountInCents());
        $this->assertEquals($stub['received'][0]['amount_localized'], $received->getLocalizedAmount());
        $this->assertEquals($stub['received'][0]['sender'], $received->getSender());
    }

    /** @test */
    public function it_gets_transfers_for_another_account()
    {
        $stub = $this->getStub('responses/all_transfers_response_other_account.json');

        $url = 'https://api.iugu.com/v1/transfers';

        $this->client->shouldReceive('withBasicAuth')->with('bar', '')->once()
            ->andReturnSelf()
            ->shouldReceive('get')
            ->andReturn(new ZttpResponse(
                \Mockery::mock(new Response)->shouldReceive('getBody')->andReturn(json_encode($stub))->getMock()
            ));

        $transfer = $this->iugu->transfers()->all('bar');

        $sent = $transfer['sent'];
        $received = $transfer['received'];

        $this->assertInstanceOf(Collection::class, $sent);
        $this->assertInstanceOf(Collection::class, $received);

        foreach ($sent as $item) {
            $this->assertInstanceOf(TransferResponse::class, $item);
        }

        foreach ($received as $item) {
            $this->assertInstanceOf(TransferResponse::class, $item);
        }

        $sent = $sent->first();

        $this->assertEquals($stub['sent'][0]['id'], $sent->getId());
        $this->assertEquals($stub['sent'][0]['created_at'], $sent->getCreatedAt());
        $this->assertEquals($stub['sent'][0]['amount_cents'], $sent->getAmountInCents());
        $this->assertEquals($stub['sent'][0]['amount_localized'], $sent->getLocalizedAmount());
        $this->assertEquals($stub['sent'][0]['receiver'], $sent->getReceiver());

        $received = $received->first();

        $this->assertEquals($stub['received'][0]['id'], $received->getId());
        $this->assertEquals($stub['received'][0]['created_at'], $received->getCreatedAt());
        $this->assertEquals($stub['received'][0]['amount_cents'], $received->getAmountInCents());
        $this->assertEquals($stub['received'][0]['amount_localized'], $received->getLocalizedAmount());
        $this->assertEquals($stub['received'][0]['sender'], $received->getSender());
    }

}
