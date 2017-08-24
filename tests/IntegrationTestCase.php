<?php

namespace Mateusjatenee\Iugu\Tests;

use Mateusjatenee\Iugu\Iugu;
use PHPUnit\Framework\TestCase as BaseTestCase;

class IntegrationTestCase extends BaseTestCase
{
    public function setUp()
    {
        if (!getenv('API_KEY') || !getenv('ACCOUNT_ID')) {
            $this->markTestSkipped('This test requires an account ID and an API key.');
        }

        $this->iugu = (new Iugu('foo'))->setUnitTesting(true)->setTesting(true);
    }

    public function assertResponseIsOk($response)
    {
        $this->assertTrue($response->isOk());
    }
}
