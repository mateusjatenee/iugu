<?php

namespace Mateusjatenee\Iugu\Fakes;

use Mateusjatenee\Iugu\Iugu;
use PHPUnit\Framework\Assert as PHPUnit;

class SubAccountFake
{
    protected $createdAccounts = [];

    protected $foundAccounts = [];

    public function assertCreated($callback = null)
    {
        PHPUnit::assertTrue(
            $this->accountCreated($callback)->count() > 0,
            "The expected account was not created."
        );
    }

    public function assertFound($id)
    {
        PHPUnit::assertTrue(
            $this->accountSearchedFor($id)->count() > 0,
            "The expected account with id {$id} was not searched for."
        );
    }

    public function accountCreated($callback = null)
    {
        $callback = $callback ?: function () {
            return true;
        };

        return collect($this->createdAccounts)->filter(function ($data) use ($callback) {
            return $callback($data);
        });
    }

    public function accountSearchedFor($id)
    {
        return collect($this->foundAccounts)->filter(function ($data) use ($id) {
            return $data === $id;
        });
    }

    public function create($data)
    {
        $this->createdAccounts[] = $data;
    }

    public function find($id)
    {
        $this->foundAccounts[] = $id;
    }

    public function verify($id, $data)
    {

    }

    public function requestWithdraw($id, $amount)
    {

    }
}
