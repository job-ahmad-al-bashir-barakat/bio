<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('link',function () {
    Artisan::call('storage:link');
    symlink("~/app/storage/app/public", "~/app/public/storage");
});
Route::group([
    'middleware' => ['web', 'localeSessionRedirect', 'localizationRedirect'],
    'prefix' => LaravelLocalization::setLocale()
], function () {

    Route::auth();

    Route::get('/'        ,'MainController@home');
    Route::get('profile'  ,'MainController@profile'); // auth
    Route::post('profile' ,'MainController@changeProfile'); // auth

    /**
     * Jobs
     */
    Route::get('jobs'                 ,'JobController@index');
    Route::get('my-jobs'              ,'JobController@owner'); // auth
    Route::get('job/suggestion'      ,'JobController@suggestion'); // auth
    Route::get('job/{id}'             ,'JobController@show');
    Route::get('job/{id}/apply'       ,'JobController@apply'); // auth
    Route::post('job/{id}/apply/send' ,'JobController@send'); // auth
    Route::post('job/filled'          ,'JobController@filled'); // auth
    Route::get('category/{id}/jobs'   ,'JobController@category');

    /**
     * resume
     */
    Route::get('resumes'                 ,'ResumeController@index');
    Route::get('my-resumes'              ,'ResumeController@owner'); // auth
    Route::get('resume/suggestion'      ,'ResumeController@suggestion'); // auth
    Route::get('resume/{id}'             ,'ResumeController@show');
    Route::get('resume/{id}/apply'       ,'ResumeController@apply'); // auth
    Route::post('resume/{id}/apply/send' ,'ResumeController@send'); // auth

    /**
     * company
     */
    Route::get('companies'    ,'CompanyController@index');
    Route::get('my-companies' ,'CompanyController@owner'); // auth
    Route::get('company/{id}' ,'CompanyController@show');

    /**
     * extra
     */
    Route::get('news'     ,'MainController@news');
    Route::get('contact'  ,'ContactController@index'); // auth
    Route::post('contact' ,'ContactController@mailToAdmin'); // auth
    Route::get('faq'      ,'MainController@faq');
    // Route::get('about'   ,'MainController@about');
    // Route::get('gallery' ,'MainController@gallery');

    Route::post('like/{model}/{modelId}'    ,'LikeController@store'); // auth
    Route::get('comment/{model}/{modelId}'  ,'CommentController@index');
    Route::post('comment/{model}/{modelId}' ,'CommentController@store'); // auth
    Route::delete('comment/{id}'            ,'CommentController@destroy'); // auth
    Route::post('rate/{model}/{modelId}'    ,'RateController@store'); // auth
});
