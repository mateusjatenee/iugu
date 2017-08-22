<?php

namespace Mateusjatenee\Iugu;

use Illuminate\Support\ServiceProvider;
use Mateusjatenee\Iugu\Iugu;
use Zttp\PendingZttpRequest;

class IuguServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('iugu', function ($app) {
            return new Iugu(new PendingZttpRequest);
        });
    }
}
