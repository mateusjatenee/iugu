<?php

namespace Mateusjatenee\Iugu\Tests\Fakes;

use Mateusjatenee\Iugu\Fakes\BaseFake;
use Mateusjatenee\Iugu\Tests\TestCase;

class BaseFakeTest extends TestCase
{
    public function setUp()
    {
        $this->fake = new BaseFake;
    }

    /** @test */
    public function it_defines_a_response()
    {
        $this->fake->setResponse([
            'foo' => 'bar',
        ]);

        $this->assertEquals('bar', $this->fake->foo);
    }
}
