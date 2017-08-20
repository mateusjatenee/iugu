<?php

namespace Mateusjatenee\Iugu\Responses;

use Illuminate\Support\Collection;
use Mateusjatenee\Iugu\Responses\BaseResponse;

class TransferResponse extends BaseResponse
{
    public function getId()
    {
        return $this->id;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getAmountInCents()
    {
        return $this->amount_cents;
    }

    public function getLocalizedAmount()
    {
        return $this->amount_localized;
    }

    public function getReceiver()
    {
        return $this->receiver;
    }

    public function getSender()
    {
        return $this->sender;
    }

    public static function collection($data)
    {
        $data = $data->json();

        return [
            'sent' => (new Collection($data['sent']))->map(function ($item) {
                return new static($item);
            }),
            'received' => (new Collection($data['received']))->map(function ($item) {
                return new static($item);
            }),
        ];
    }
}
