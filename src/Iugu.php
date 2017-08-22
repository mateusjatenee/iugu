<?php

namespace Mateusjatenee\Iugu;

use Mateusjatenee\Iugu\Charge;
use Mateusjatenee\Iugu\SubAccount;

class Iugu
{
    /**
     * The HTTP client
     * @var mixed
     */
    public $client;

    /**
     * The API token
     * @var string
     */
    protected $token;

    /**
     * @param mixed $client
     * @param string|null $token
     */
    public function __construct($client, $token = null)
    {
        $this->client = $client;
        $this->token = $token;
        $this->setAuth($token);
    }

    /**
     * Returns a Charge instance or performs a direct charge.
     *
     * @param array|null $data
     * @return \Mateusjatenee\Iugu\Charge
     */
    public function charge($data = null)
    {
        if ($data) {
            return (new Charge($this))->directCharge($data);
        }

        return new Charge($this);
    }

    /**
     * Returns a Transfer instance.
     *
     * @return \Mateusjatenee\Iugu\Transfer
     */
    public function transfers()
    {
        return new Transfer($this);
    }

    public function subAccounts()
    {
        return new SubAccount($this);
    }

    public function marketplace()
    {
        return $this->subAccounts();
    }

    /**
     * Gets the HTTP client
     *
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Sets the API token and basic auth.
     *
     * @param string $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;

        return tap($this)->setAuth($token, '');
    }

    /**
     * Sets the basic auth headers.
     *
     * @param string $user
     * @param string $password
     * @return $this
     */
    public function setAuth($user, $password = '')
    {
        if (is_null($user)) {
            return $this;
        }

        unset($this->client->options['auth']);

        return tap($this, function ($iugu) use ($user, $password) {
            $iugu->client->withBasicAuth($user, $password);
        });
    }
}
