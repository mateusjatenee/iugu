<?php

namespace Mateusjatenee\Iugu\Tests;

use Mateusjatenee\Iugu\Iugu;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Zttp\PendingZttpRequest;

class TestCase extends BaseTestCase
{
    public static function setUpBeforeClass()
    {
        TestServer::start();
    }

    public function setUp()
    {
        $this->iugu = new Iugu(new PendingZttpRequest);
    }

    public function getStub($stub)
    {
        return json_decode(file_get_contents(
            __DIR__ . '/server/public/stubs/' . $stub
        ), true);
    }

    public function url($url)
    {
        return vsprintf('%s/%s', [
            'http://localhost:' . getenv('TEST_SERVER_PORT'),
            ltrim($url, '/'),
        ]);
    }
}
