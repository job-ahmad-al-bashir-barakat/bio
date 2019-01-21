<?php

namespace Aut\GoogleMap;

use Illuminate\Support\ServiceProvider;

class GoogleMapServiceProvider extends ServiceProvider
{
    /**
     * Vendor name.
     *
     * @var string
     */
    protected $vendor   = 'aut';

    /**
     * Package name.
     *
     * @var string
     */
    protected $package  = 'googlemap';

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslations();

        $this->publishFileUploadAssets();
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerHelper();

        $this->registerViews();
    }

    protected function publishFileUploadAssets()
    {
         // publish assets
         $this->publishes([
             __DIR__.'/Assets' => public_path('vendor/gmap'),
         ], 'public');
    }

    /**
     * register our helper
     */
    protected function registerHelper()
    {
         require_once('Helper/helpers.php');
    }

    /**
     * register our view
     */
    protected function registerViews()
    {
        $this->loadViewsFrom(__DIR__ . '/Resources/Views', 'gmap');
    }

    /**
     * register our lang
     */
    protected function loadTranslations()
    {
        $this->loadTranslationsFrom(__DIR__ . '/Resources/Lang', 'gmap');
    }

}