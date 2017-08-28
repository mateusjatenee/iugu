<?php

namespace Mateusjatenee\Iugu;

use Mateusjatenee\Iugu\Resource;
use Mateusjatenee\Iugu\Responses\SubAccountResponse;

class SubAccount extends Resource
{
    private $iugu;

    /**
     * @param \Mateusjatenee\Iugu\Iugu $iugu
     */
    public function __construct($iugu)
    {
        $this->iugu = $iugu;
    }

    public function create($data)
    {
        $response = $this->iugu->client->post(
            $this->getEndpoint('marketplace.create_account'), $data
        );

        return $response->to(SubAccountResponse::class);
    }

    public function find($id)
    {
        $response = $this->iugu->client->get(
            $this->getEndpoint('accounts', ['id' => $id])
        );

        return $response->to(SubAccountResponse::class);
    }

    public function verify($id, $data)
    {
        if ($id instanceof SubAccountResponse) {
            $userToken = $id->user_token;
            $id = $id->getId();
        } else {
            [$id, $userToken] = $id;
        }

        $token = tap($this->iugu->token, function () use ($userToken) {
            $this->iugu->setAuth($userToken);
        });

        $response = $this->iugu->client->post(
            $this->getEndpoint('accounts.verify', ['id' => $id]), $data
        );

        $this->iugu->setAuth($token);

        return $response->to(SubAccountResponse::class);
    }

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
