<?php

namespace Mateusjatenee\Iugu\Responses;

use Illuminate\Support\Collection;
use Mateusjatenee\Iugu\Responses\BaseResponse;

class TransferResponse extends BaseResponse
{
    /**
     * Get the transfer unique ID.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the transfer created at timestamp.
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Get the transfered amount in cents.
     *
     * @return string
     */
    public function getAmountInCents()
    {
        return $this->amount_cents;
    }

    /**
     * Get the transfered amount in a localized format.
     *
     * @return string
     */
    public function getLocalizedAmount()
    {
        return $this->amount_localized;
    }

    /**
     * Get the transfer recipient data.
     *
     * @return array
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * Get the transfer sender data.
     *
     * @return string
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Generate an array of transfers based on a response.
     *
     * @param \Zttp\ZttpResponse $response
     * @return array
     */
    public static function collection($response)
    {
        $data = $response->json();

        return [
            'sent' => (new Collection($data['sent']))->map(function ($item) use ($response) {
                return new static($item, $response);
            }),
            'received' => (new Collection($data['received']))->map(function ($item) use ($response) {
                return new static($item, $response);
            }),
        ];
    }
}
