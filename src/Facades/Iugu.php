<?php

namespace Mateusjatenee\Iugu\Facades;

use Illuminate\Support\Facades\Facade;

class Iugu extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'iugu';
    }
}
