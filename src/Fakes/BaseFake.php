<?php

namespace Mateusjatenee\Iugu\Fakes;

class BaseFake
{
    protected $defaultResponse;

    public function __get($property)
    {
        if ($this->defaultResponse) {
            return $this->defaultResponse[$property];
        }

        return $this->data[$property] ?? null;
    }

    public function getStub($stub)
    {
        return json_decode(
            file_get_contents(__DIR__ . '/Stubs/' . $stub), true
        );
    }

    public function toArray()
    {
        return $this->data;
    }

    public function setResponse(array $data)
    {
        $this->defaultResponse = $data;

        return $this;
    }
}
