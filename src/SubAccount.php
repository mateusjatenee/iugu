<?php

namespace Mateusjatenee\Iugu;

use Mateusjatenee\Iugu\Resource;
use Mateusjatenee\Iugu\Responses\SubAccountResponse;

class SubAccount extends Resource
{
    /**
     * @var \Mateusjatenee\Iugu\Iugu
     */
    private $iugu;

    /**
     * @param \Mateusjatenee\Iugu\Iugu $iugu
     */
    public function __construct($iugu)
    {
        $this->iugu = $iugu;
    }

    /**
     * Creates a sub account.
     *
     * @param array $data
     * @return \Mateusjatenee\Iugu\Responses\SubAccountResponse
     */
    public function create($data)
    {
        $response = $this->iugu->client->post(
            $this->getEndpoint('marketplace.create_account'), $data
        );

        return $response->to(SubAccountResponse::class);
    }

    /**
     * Finds a sub account.
     *
     * @param string $id
     * @return \Mateusjatenee\Iugu\Responses\SubAccountResponse
     */
    public function find($id)
    {
        $response = $this->iugu->client->get(
            $this->getEndpoint('accounts', ['id' => $id])
        );

        return $response->to(SubAccountResponse::class);
    }

    /**
     * Verifies a given sub account.
     *
     * @param array|\Mateusjatenee\Iugu\Responses\SubAccountResponse $id
     * @param array $data
     * @return \Mateusjatenee\Iugu\Responses\SubAccountResponse
     */
    public function verify($id, $data)
    {
        if ($id instanceof SubAccountResponse) {
            $userToken = $id->user_token;
            $id = $id->getId();
        } else {
            list($id, $userToken) = $id;
        }

        $token = tap($this->iugu->token, function () use ($userToken) {
            $this->iugu->setAuth($userToken);
        });

        $response = $this->iugu->client->post(
            $this->getEndpoint('accounts.verify', ['id' => $id]), ['data' => $data]
        );

        $this->iugu->setAuth($token);

        return $response->to(SubAccountResponse::class);
    }

    /**
     * @param $id
     * @param $amount
     * @return mixed
     */
    public function requestWithdraw($id, $amount)
    {
        if ($id instanceof SubAccountResponse) {
            $id = $id->id;
        }

        $response = $this->iugu->client->post(
            $this->getEndpoint('accounts.withdraw', ['id' => $id]), ['amount' => $amount]
        );

        return $response->to(SubAccountResponse::class);
    }

}
