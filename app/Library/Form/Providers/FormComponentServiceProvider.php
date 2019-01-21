<?php

namespace App\Library\Form\Providers;

use App\Library\Form\FormComponent;
use Illuminate\Support\ServiceProvider;

class FormComponentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
       // boot
    }

    public function register()
    {
        $this->app->singleton('FormComponent', function ($app) {
            return new FormComponent();
        });
    }
}