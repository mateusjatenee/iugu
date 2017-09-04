<?php

namespace Mateusjatenee\Iugu\Fakes;

use Mateusjatenee\Iugu\Iugu;
use PHPUnit\Framework\Assert as PHPUnit;

class ChargeFake extends BaseFake
{
    protected $tokens;

    protected $charges;

    protected $expectedResponse = null;

    public function assertTokenWasGenerated($callback = null)
    {
        PHPUnit::assertTrue(
            $this->tokenGenerated($callback)->count() > 0,
            "The expected token was not generated."
        );
    }

    public function assertCharged($callback = null)
    {
        PHPUnit::assertTrue(
            $this->charged($callback)->count() > 0,
            "The expected charge was not found."
        );
    }

    public function generateToken($accountId, $data)
    {
        $this->tokens[] = array_merge([
            'account_id' => $accountId,
        ], $data);

        $this->data = $this->getStub('token.json');

        return $this;
    }

    public function directCharge($data)
    {
        $this->charges[] = $data;

        $this->data = $this->getStub('charge.json');

        return $this;
    }

    /**
     * Get all of the tokens matching a truth-test callback.
     *
     * @param  callable|null  $callback
     * @return \Illuminate\Support\Collection
     */
    public function tokenGenerated($callback = null)
    {
        $callback = $callback ?: function () {
            return true;
        };

        return collect($this->tokens)->filter(function ($data) use ($callback) {
            return $callback($data);
        });
    }

    /**
     * Get all of the charges matching a truth-test callback.
     *
     * @param  callable|null  $callback
     * @return \Illuminate\Support\Collection
     */
    public function charged($callback = null)
    {
        $callback = $callback ?: function () {
            return true;
        };

        return collect($this->charges)->filter(function ($data) use ($callback) {
            return $callback($data);
        });
    }

    public function getToken()
    {
        return $this->id;
    }
}
