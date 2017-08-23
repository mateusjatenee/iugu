<?php

namespace Mateusjatenee\Iugu;

use Mateusjatenee\Iugu\Charge;
use Mateusjatenee\Iugu\Exceptions\FailedRequestException;
use Mateusjatenee\Iugu\SubAccount;
use Zttp\PendingZttpRequest;
use Zttp\ZttpResponse;

class Iugu
{
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

    /**
     * @param mixed $client
     * @param string|null $token
     */
    public function __construct($client, $token = null)
    {
        ZttpResponse::macro('to', function ($class) {
            if (!$this->isOk()) {
                throw new FailedRequestException($this);
            }

            return new $class($this);
        });

        $this->client = $client;
        $this->token = $token;
        $this->setAuth($token);
        self::setInstance($this);
    }

    /**
     * Set the globally available instance of the class.
     *
     * @return static
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static(new PendingZttpRequest);
        }

        return static::$instance;
    }

    /**
     * Set the shared instance of the class.
     *
     * @param  \Mateusjatenee\Iugu\Iugu  $container
     * @return static
     */
    public static function setInstance($iugu = null)
    {
        return static::$instance = $iugu;
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
