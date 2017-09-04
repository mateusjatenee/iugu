<?php

namespace Mateusjatenee\Iugu\Responses;

use Mateusjatenee\Iugu\Responses\BaseResponse;

class TokenResponse extends BaseResponse
{
    /**
     * Get the token.
     *
     * @return string
     */
    public function getToken()
    {
        return $this->id;
    }
}
