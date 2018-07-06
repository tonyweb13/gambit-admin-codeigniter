<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

if (app()->environment() <> 'production') {
	Route::get('logs', ['as' => 'logs', 'uses' => '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index']);
}

Route::group(['prefix'=>'test'], function() {
	Route::controller('directives', '\App\Http\Controllers\Test\Directives');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::resource('agents', \App\Http\Controllers\Resources\Agent::class, ['except' => ['create', 'edit']]);
Route::resource('countries', \App\Http\Controllers\Resources\Country::class, ['except' => ['create', 'edit']]);
Route::resource('currencies', \App\Http\Controllers\Resources\Currency::class, ['except' => ['create', 'edit']]);
Route::resource('gsps', \App\Http\Controllers\Resources\Gsp::class, ['except' => ['create', 'edit']]);
Route::resource('managers', \App\Http\Controllers\Resources\Manager::class, ['except' => ['create', 'edit']]);
Route::resource('language', \App\Http\Controllers\Resources\Language::class, ['except' => ['create', 'edit']]);
Route::group(['middleware' => 'verify-resource.agent'], function() {
	Route::resource('agents.configurations', \App\Http\Controllers\Resources\AgentConfiguration::class, ['except' => ['create', 'edit']]);
	Route::resource('agents.operations', \App\Http\Controllers\Resources\AgentOperation::class, ['except' => ['create', 'edit']]);
	Route::resource('agents.servers', \App\Http\Controllers\Resources\AgentServer::class, ['except' => ['create', 'edit']]);
});
Route::group(['middleware' => 'verify-resource.gsp'], function() {
	Route::resource('gsps.additional-information', \App\Http\Controllers\Resources\GspAdditionalInformation::class, ['except' => ['create', 'edit']]);
	Route::resource('gsps.currencies', \App\Http\Controllers\Resources\GspCurrency::class, ['except' => ['create', 'edit']]);
	Route::resource('gsps.urls', \App\Http\Controllers\Resources\GspUrl::class, ['except' => ['create', 'edit']]);
});
