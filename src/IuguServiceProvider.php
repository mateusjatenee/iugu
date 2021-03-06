<?php

namespace Mateusjatenee\Iugu;

use Illuminate\Support\ServiceProvider;
use Mateusjatenee\Iugu\Iugu;

class IuguServiceProvider extends ServiceProvider
{
    public function register()
    {
        $apiToken = config('services.iugu.api_token');

        $this->app->singleton('iugu', function ($app) use ($apiToken) {
            return new Iugu($apiToken);
        });
    }
}
