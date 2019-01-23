<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;
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
		if($this->app->environment('production')) {
            // force https
            \URL::forceScheme('https');
        }

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

        if($this->app->environment('production')) {

            // force https
            $this->app['request']->server->set('HTTPS', true);

            // set db config
            $url = parse_url(getenv("CLEARDB_DATABASE_URL"));

            $host = $url["host"];
            $username = $url["user"];
            $password = $url["pass"];
            $database = substr($url["path"], 1);

            Config::set('database.connections.mysql.host',$host);
            Config::set('database.connections.mysql.username',$username);
            Config::set('database.connections.mysql.password',$password);
            Config::set('database.connections.mysql.database',$database);
        }
    }
}
