<?php

namespace Mateusjatenee\Iugu;

use Mateusjatenee\Iugu\Charge;

class Iugu
{
    public $client;

    protected $token;

    public function __construct($client, $token = null)
    {
        $this->client = $client;
        $this->token = $token;
    }

    public function charge()
    {
        return new Charge($this);
    }

    public function getClient()
    {
        return $this->client;
    }

    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    public function foo()
    {
        return $this->client->foo();
    }
}
