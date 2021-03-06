<?php

namespace Mateusjatenee\Iugu\Tests;

use Mateusjatenee\Iugu\Fakes\IuguFake;
use Mateusjatenee\Iugu\Iugu;
use Mateusjatenee\Iugu\Tests\TestCase;

class IuguTest extends TestCase
{
    /** @test */
    public function it_correctly_sets_the_auth()
    {
        $client = $this->iugu->client;

        $response = $this->iugu->setAuth('foo');

        $response = $this->iugu->client->get(
            $this->url('/auth')
        )->json();

        $headers = $response['headers'];

        $this->assertEquals('application/json', $headers['accept'][0]);
        $this->assertEquals('foo', $headers['php-auth-user'][0]);
        $this->assertEquals('', $headers['php-auth-pw'][0]);
    }

    /** @test */
    public function it_swaps_for_a_fake_instance()
    {
        $this->assertInstanceOf(Iugu::class, Iugu::get());

        $instance = tap(Iugu::get(), function ($iugu) {
            Iugu::fake();
        });

        $this->assertInstanceOf(IuguFake::class, Iugu::get());

        Iugu::setInstance($instance);
    }

}
