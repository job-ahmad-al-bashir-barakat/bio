<?php

namespace Aut\Autocomplete;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;
use LaravelLocalization;

class AutocompleteServiceProvider extends ServiceProvider
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
    protected $package  = 'autocomplete';

    protected $commands = [];

    protected $namespace = 'Aut\Autocomplete\Http\Controllers';

    protected $middleware;

    function __construct(\Illuminate\Foundation\Application $app)
    {
        parent::__construct($app);

        $this->registerConfig();

        $this->commands = $this->registerCommandByVersion($this->commands);
    }

    public function boot(Router $router)
    {
        $this->routeMiddleware();

        $this->registerRoute($router);

        $this->publishAutocomplete();

        $this->loadTranslations();
    }

    /**
     * register our lang
     */
    protected function loadTranslations()
    {
        $this->loadTranslationsFrom(__DIR__.'/Resources/Lang', 'autocomplete');
    }

    protected function registerCommandByVersion($commands)
    {
        $laravel = app();
        $version = preg_match('/\d\.\d/',$laravel::VERSION ,$v);

        if($version)
            $version = $v[0];
        else
            $version = config('autocomplete.version');

        switch ($version)
        {
            default : {
                return array_merge($commands ,[
                    \Aut\Autocomplete\Commands\MakeAutocompleteCommand::class,
                ]);
            }; break;
        }
    }

    private function publishAutocomplete()
    {
        // publish config
        $this->publishes([
            __DIR__.'/Config/autocomplete.php' => config_path('autocomplete.php')
        ], 'config');

        // publish assets
        $this->publishes([
            __DIR__.'/Assets' => public_path('vendor/autocomplete'),
        ], 'public');
    }

    private function registerRoute(Router $router)
    {
        $router->group(
            [
                'prefix'     => LaravelLocalization::setLocale() . "/autocomplete",
                'namespace'  => $this->namespace,
                'middleware' => $this->middleware
            ],
            function () {

                Route::get('{model}', "AutocompleteController@autocomplete");
                Route::post('{model}', "AutocompleteController@store");
                Route::put('{model}/{id}', "AutocompleteController@approvied");
                Route::delete('{model}/{id}', "AutocompleteController@destroy");
            });
    }

    private function routeMiddleware()
    {
        $routeMiddleware = config('autocomplete.routeMiddleware') == null
            ? ['web', 'localeSessionRedirect', 'localizationRedirect' ]
            : config('autocomplete.routeMiddleware');

        $this->middleware =  $routeMiddleware;
    }

    protected function registerController()
    {
        // register our controller
        $this->app->make('Aut\Autocomplete\Http\Controllers\AutocompleteController');
    }

    protected function registerHelper()
    {
        // add helper method to my project
        require_once('Helper/helpers.php');
    }

    function registerCommands()
    {
        $this->commands($this->commands);
    }

    protected function registerViews()
    {
        //register our view
        $this->loadViewsFrom(__DIR__.'/Resources/Views', 'autocomplete');
    }

    protected function registerConfig()
    {
        //register our config
        if(!file_exists(base_path('config/autocomplete.php')))
            $this->mergeConfigFrom(__DIR__.'/Config/autocomplete.php' ,'autocomplete');
    }

    public function register()
    {
        $this->registerController();
        $this->registerHelper();
        $this->registerCommands();
        $this->registerViews();
    }
}