<?php

namespace Mateusjatenee\Iuug\Facades;

use Illuminate\Support\Facades\Facade;

class Iugu extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'iugu';
    }
}
