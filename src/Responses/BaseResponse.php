<?php

namespace Mateusjatenee\Iugu\Responses;

use Mateusjatenee\Iugu\Iugu;
use Zttp\ZttpResponse;

class BaseResponse
{
    /**
     * @param \Zttp\ZttpResponse|array $data
     * @param $response
     */
    public function __construct($data, $response = null)
    {
        $this->data = $data instanceof ZttpResponse ? $data->json() : $data;
        $this->response = $this->getResponse($data, $response);
    }

    /**
     * Dynamically gets a response property.
     *
     * @param $property
     * @return mixed
     */
    public function __get($property)
    {
        return $this->data[$property] ?? null;
    }

    /**
     * Returns an array of the current response.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * Determines wether the request succeeded.
     *
     * @return bool
     */
    public function isOk()
    {
        return $this->response->isOk();
    }

    /**
     * Gets the current \Mateusjatenee\Iugu\Iugu instance.
     *
     * @return \Mateusjatenee\Iugu\Iugu
     */
    public function getIugu()
    {
        return Iugu::getInstance();
    }

    /**
     * @param $data
     * @param $response
     * @return mixed
     */
    protected function getResponse($data, $response)
    {
        if ($response) {
            return $response;
        }

        return $data instanceof ZttpResponse ? $data : null;
    }

    /**
     * @param $data
     * @return mixed
     */
    protected function isFailedRequest($data)
    {
        return $data instanceof ZttpResponse && !$data->isOk();
    }
}
