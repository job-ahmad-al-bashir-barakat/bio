<?php

namespace App\Library\Url\Providers;

use App\Library\Url\RouteUrls;
use Illuminate\Support\ServiceProvider;

class RouteUrlsServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('RouteUrls', function ($app) {
            return new RouteUrls();
        });
    }
}