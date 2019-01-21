<?php

namespace App\Library\Url\Facades;

use Illuminate\Support\Facades\Facade;

class RouteUrls extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'RouteUrls';
    }
}