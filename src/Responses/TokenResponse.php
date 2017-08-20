<?php

namespace Mateusjatenee\Iugu\Responses;

use Mateusjatenee\Iugu\Responses\BaseResponse;

class TokenResponse extends BaseResponse
{
    public function getToken()
    {
        return $this->id;
    }
}
