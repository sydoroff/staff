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

Route::get('/', function () {
    return view('welcome');
});

Route::view('/table/ajax/','table-ajax')->name('staff.ajax')->middleware('auth');

Route::get('/api/table/', 'ApiController@table')->name('api.table')->middleware('auth');
Route::post('/api/move/','ApiController@move')->name('api.staff.move')->middleware('auth');

Route::resource('staff', 'StaffController',['except' => [
                                    'index', 'show'
                                        ]]);

Route::post('/staff/image/{id}','StaffController@image')->where('id', '[0-9]+')->name('staff.image');
Route::post('/staff/subordinate/','StaffController@subordinate')->name('staff.subordinate');

Route::get('/table/', 'StaffController@index')->name('staff');

Auth::routes();

Route::redirect('/home', '/table/ajax/');
