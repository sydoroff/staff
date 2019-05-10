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




Route::get('/home/', 'ApiController@home')->name('api.home');
Route::get('/names/', 'ApiController@nameTree')->name('api.names');
Route::get('/worker/{id}/', 'ApiController@worker')->where('id', '[0-9]+')->name('api.worker');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
