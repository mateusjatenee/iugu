<?php

namespace Mateusjatenee\Iugu\Tests;

use Mateusjatenee\Iugu\Iugu;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Zttp\PendingZttpRequest;

class TestCase extends BaseTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->client = $this->getMockedClient();
        $this->iugu = new Iugu($this->client);
    }

    protected function getMockedClient()
    {
        return \Mockery::mock(new PendingZttpRequest);
    }

    public function getStub($stub)
    {
        return json_decode(file_get_contents(
            __DIR__ . '/stubs/' . $stub
        ), true);
    }
}
