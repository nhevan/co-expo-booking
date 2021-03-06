<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->get('/events', 'EventsController@index')->name('events.index');
Route::middleware('api')->get('/events/{event}', 'EventsController@show')->name('events.show');
Route::middleware('api')->post('/stands/{stand}/reserve', 'StandsController@reserve')->name('stands.reserve');
Route::middleware('api')->post('/companies/{company}/upload-document', 'CompaniesController@saveDocuments')->name('company.saveDocument');