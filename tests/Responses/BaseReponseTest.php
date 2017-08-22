<?php

namespace Mateusjatenee\Iugu\Tests\Responses;

use Mateusjatenee\Iugu\FailedRequest;
use Mateusjatenee\Iugu\Iugu;
use Mateusjatenee\Iugu\Responses\ChargeResponse;
use Mateusjatenee\Iugu\Tests\TestCase;

class BaseResponseTest extends TestCase
{
    /** @test */
    public function it_handles_422_errors()
    {
        $response = $this->iugu->client->get($this->url('422'));

        $failedRequest = new FailedRequest($response);

        $this->assertInstanceOf(FailedRequest::class, $failedRequest);
        $this->assertFalse($failedRequest->isOk());
        $this->assertEquals([
            'due_date' => [
                'should not be in the past',
            ],
        ], $failedRequest->getErrors()
        );
    }

    /** @test */
    public function it_handles_other_errors()
    {
        $response = $this->iugu->client->get($this->url('401'));

        $failedRequest = new FailedRequest($response);

        $this->assertInstanceOf(FailedRequest::class, $failedRequest);
        $this->assertFalse($failedRequest->isOk());
        $this->assertEquals('Unauthorized', $failedRequest->getErrors()
        );
    }

    /** @test */
    public function it_automatically_returns_a_failed_response()
    {
        $response = $this->iugu->client->get($this->url('422'));

        $response = $response->to(ChargeResponse::class);

        $this->assertInstanceOf(FailedRequest::class, $response);
        $this->assertFalse($response->isOk());
        $this->assertEquals([
            'due_date' => [
                'should not be in the past',
            ],
        ], $response->getErrors()
        );
    }

}
