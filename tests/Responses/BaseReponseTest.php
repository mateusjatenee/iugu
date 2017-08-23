<?php

namespace Mateusjatenee\Iugu\Tests\Responses;

use Mateusjatenee\Iugu\Exceptions\FailedRequestException;
use Mateusjatenee\Iugu\Iugu;
use Mateusjatenee\Iugu\Responses\ChargeResponse;
use Mateusjatenee\Iugu\Tests\TestCase;

class BaseResponseTest extends TestCase
{
    /** @test */
    public function it_handles_422_errors()
    {
        $response = $this->iugu->client->get($this->url('422'));

        $exception = new FailedRequestException($response);

        $this->assertFalse($exception->isOk());
        $this->assertEquals([
            'due_date' => [
                'should not be in the past',
            ],
        ], $exception->getErrors()
        );
    }

    /** @test */
    public function it_handles_other_errors()
    {
        $response = $this->iugu->client->get($this->url('401'));

        $exception = new FailedRequestException($response);

        $this->assertFalse($exception->isOk());
        $this->assertEquals('Unauthorized', $exception->getErrors());
    }

    /** @test */
    public function it_automatically_returns_a_failed_response()
    {
        $response = $this->iugu->client->get($this->url('422'));

        try {
            $response = $response->to(ChargeResponse::class);
        } catch (FailedRequestException $exception) {
            $this->assertInstanceOf(FailedRequestException::class, $exception);
            $this->assertFalse($exception->isOk());
            $this->assertEquals([
                'due_date' => [
                    'should not be in the past',
                ],
            ], $exception->getErrors()
            );
        }

    }
}
