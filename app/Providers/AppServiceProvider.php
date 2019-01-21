<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->setDefaultSchemaStringLength();
        $this->morphMap();
    }

    function morphMap()
    {
        Relation::morphMap([
            'news'      => \Modules\Control\Entities\News::class,
            'company'   => \Modules\Control\Entities\Company::class,
        ]);
    }

    /**
     * Default Schema String Length
     */
    function setDefaultSchemaStringLength()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
