<?php

namespace Mateusjatenee\Iugu;

use Mateusjatenee\Iugu\Charge;
use Mateusjatenee\Iugu\Exceptions\FailedRequestException;
use Mateusjatenee\Iugu\Singleton;
use Mateusjatenee\Iugu\SubAccount;
use Zttp\PendingZttpRequest;
use Zttp\ZttpResponse;

class Iugu
{
    use Singleton;

    protected static $instance;

    /**
     * The HTTP client
     * @var mixed
     */
    public $client;

    /**
     * The API token
     * @var string
     */
    public $token;

    public $testing = false;

    public $unitTesting = false;

    /**
     * @param mixed $client
     * @param string|null $token
     */
    public function __construct($token = null)
    {
        $this->registerMacros();
        $this->setClient();
        $this->setHeaders();
        $this->setAuth($token);
        static::setInstance($this);
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

    /**
     * Returns a SubAccount instance.
     *
     * @return \Mateusjatenee\Iugu\SubAccount
     */
    public function subAccounts()
    {
        return new SubAccount($this);
    }

    /**
     * An alias to the subAccounts method.
     *
     * @return \Mateusjatenee\Iugu\SubAccount
     */
    public function marketplace()
    {
        return $this->subAccounts();
    }

    /**
     * Returns an instance of Invoice.
     *
     * @return \Mateusjatenee\Iugu\Invoice
     */
    public function invoices()
    {
        return new Invoice($this);
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
     * Sets the HTTP client.
     *
     * @param $client
     */
    public function setClient($client = null)
    {
        if (is_null($client)) {
            $client = new PendingZttpRequest;
        }

        $this->client = $client;

        return $this;
    }

    /**
     * Sets the default HTTP headers.
     */
    public function setHeaders()
    {
        $this->client->withHeaders([
            'Accept' => 'application/json',
        ]);

        return $this;
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
            $iugu->token = $user;
            $iugu->client->withBasicAuth($user, $password);
        });
    }

    public function setTesting($testing = false)
    {
        $this->testing = $testing;

        return $this;
    }

    public function setUnitTesting($testing = false)
    {
        $this->unitTesting = $testing;

        return $this;
    }

    /**
     * Register the necessary macros.
     *
     * @return void
     */
    public function registerMacros()
    {
        ZttpResponse::macro('to', function ($class) {
            if (!$this->isOk()) {
                throw new FailedRequestException($this);
            }

            return new $class($this);
        });
    }
}
