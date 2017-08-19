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
        $this->setAuth($token, '');
    }

    public function charge($data = null)
    {
        if ($data) {
            return (new Charge($this))->directCharge($data);
        }
        return new Charge($this);
    }

    public function transfers()
    {
        return new Transfer($this);
    }

    public function getClient()
    {
        return $this->client;
    }

    public function setToken($token)
    {
        $this->token = $token;

        $this->setAuth($token, '');

        return $this;
    }

    public function setAuth($user, $password)
    {
        $this->client->withBasicAuth($user, $password);
    }

    public function foo()
    {
        return $this->client->foo();
    }
}
