<?php

namespace Mateusjatenee\Iugu\Tests;

use GuzzleHttp\Psr7\Response;
use Mateusjatenee\Iugu\Iugu;
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

}
