<?php

namespace Aut\FileUpload;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use LaravelLocalization;
use Validator;
use Route;
use Form;

class FileUploadServiceProvider extends ServiceProvider
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
    protected $package  = 'fileupload';

    protected $namespace = 'Aut\FileUpload\Http\Controllers';

    protected $middleware;

    public function __construct(\Illuminate\Foundation\Application $app)
    {
        parent::__construct($app);

        $this->registerConfig();
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $routeMiddleware = config('fileupload.routeMiddleware');

        $this->middleware =  $routeMiddleware;

        $this->mapFileUploadRoutes($router);

        $this->loadTranslations();

        $this->publishFileUploadAssets();

        $this->customValidator();

        $this->ImageUpload();

        $this->ImageUploadCropper();
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerFileUpload();

        $this->registerHelper();

        $this->registerViews();

        $this->registerController();
    }

    protected function customValidator()
    {
        Validator::extend('ratio', 'Aut\FileUpload\Http\Validators\CustomValidator@ratio');
    }

    protected function publishFileUploadAssets()
    {
         // publish config
         $this->publishes([
             __DIR__.'/Config/cropper.php'    => config_path('cropper.php'),
             __DIR__.'/Config/fileupload.php' => config_path('fileupload.php'),
         ], 'config');

         // publish assets
         $this->publishes([
             __DIR__.'/Assets' => public_path('vendor/fileupload'),
         ], 'public');
    }

    /**
     * set route datatable
     *
     * @param $router
     */
    protected function mapFileUploadRoutes($router)
    {
        $router->group([
            'prefix' => LaravelLocalization::setLocale() . '/fileupload',
            'namespace' => $this->namespace,
            'middleware' => $this->middleware
        ], function () {

            Route::post('{model}/{type}/upload','UploadController@upload');
            Route::post('{model}/{type}/destroy','UploadController@destroy');
            Route::get('{model}/{type}/upload','UploadController@index');
        });
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
        $this->loadViewsFrom(__DIR__.'/Resources/Views', 'fileupload');
    }

    /**
     * register our controller
     */
    protected function registerController()
    {
        $this->app->make('Aut\FileUpload\Http\Controllers\UploadController');
    }

    /**
     * register our config
     */
    protected function registerConfig()
    {
        if(!file_exists(base_path('config/cropper.php')))
            $this->mergeConfigFrom(__DIR__.'/Config/cropper.php' ,'cropper');

        if(!file_exists(base_path('config/fileupload.php')))
            $this->mergeConfigFrom(__DIR__.'/Config/fileupload.php' ,'fileupload');
    }

    /**
     * register our lang
     */
    protected function loadTranslations()
    {
        $this->loadTranslationsFrom(__DIR__ . '/Resources/Lang', 'fileupload');
    }

    /**
     * register our lang
     */
    protected function registerFileUpload()
    {
        $this->app->singleton('FileUpload', function ($app) {

            return new FileUpload();
        });
    }

    function ImageUpload()
    {
        Form::component('ImageUpload','fileupload::component.form.image_upload',[
            'id'                                 => '',
            'name'                               => '',
            'class'                              => '',
            'param'                              => '',
            'imageWidth'                         => null,
            'imageHeight'                        => null,
            'targetModel'                        => [
                'modalId'        => '',
                'modalTitle'     => '',
                'modalWidth'     => '700px',
            ],
            'datatable'                          => '',
            'datatableInitialize'                => 'true',
            'datatableInitializeProperty'        => '.image',
            'extraParameter'                     => [
                'maxFileCount'                   => '0',
                'minFileCount'                   => '0',
                'minImageWidth'                  => null,
                'minImageHeight'                 => null,
                'maxImageWidth'                  => null,
                'maxImageHeight'                 => null,
                'allowedFileExtensions'          => 'jpeg,jpg,bmp,png',
                'appendLocation'                 => '',
                'appendName'                     => '',
                'reloadDatatable'                => 'true',
                'fileuploadedEvent'              => '',
                'filedeletedEvent'               => '',
                'allowedPreviewIcons'            => 'false',
                'autoReplace'                    => 'false',
                'showCaption'                    => 'false',
                'showPreview'                    => 'true',
                'allowRatio'                     => 'false',
            ],
        ]);
    }

    function ImageUploadCropper()
    {
        Form::component('ImageUploadCropper','fileupload::component.form.image_cropper',[
            'width'             => '90%',
            'single'            => false,
            'showName'          => true,
            'showType'          => false,
            'showOption'        => false,
            'showToggleOption'  => false,
            'showPreview'       => false,
            'previewType'       => ['lg' ,'md' ,'sm' ,'xs'],
            'showManager'       => false,
        ]);
    }

    public function provides()
    {
        return ['FileUpload', 'Aut\FileUpload\FileUpload'];
    }
}