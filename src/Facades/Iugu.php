<?php

namespace Mateusjatenee\Iugu\Facades;

use Illuminate\Support\Facades\Facade;
use Mateusjatenee\Iugu\Fakes\IuguFake;

class Iugu extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'iugu';
    }

    /**
     * Replace the bound instance with a fake.
     *
     * @return void
     */
    public static function fake()
    {
        static::swap(new IuguFake());
    }
}
