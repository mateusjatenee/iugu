<?php

namespace Mateusjatenee\Iugu\Fakes;

class BaseFake
{
    public function __get($property)
    {
        return $this->data[$property] ?? null;
    }

    public function getStub($stub)
    {
        return json_decode(
            file_get_contents(__DIR__ . '/Stubs/' . $stub), true
        );
    }
}
