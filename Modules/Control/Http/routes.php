<?php

Route::group(['middleware' => ['web','auth','admin'], 'prefix' => LaravelLocalization::setLocale().'/control', 'namespace' => 'Modules\Control\Http\Controllers'], function()
{
    Route::get('/', 'ControlController@index')->name('home');
    Route::get('{view}','ControlController@table');
});
