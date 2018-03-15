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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/data-master', 'MasterController@index');
Route::get('/data-master/edit/{id}', 'MasterController@edit');
Route::post('/data-master/tambah', 'MasterController@store');
Route::put('/data-master/update/{id}', 'MasterController@update');
Route::delete('/data-master/delete/{id}', 'MasterController@destroy');
Route::get('/data-master/comodities/{id}', 'MasterController@getComodities');
Route::get('/data-master/comodities/edit/{id}', 'MasterController@editComodities');
Route::post('/data-master/comodities/tambah', 'MasterController@storeComodities');
Route::put('/data-master/comodities/update/{id}', 'MasterController@updateComodities');
Route::delete('/data-master/comodities/delete/{id}', 'MasterController@destroyComodities');
Route::get('/warehouse', 'WarehouseController@index');
Route::get('/warehouse/{id}', 'WarehouseController@edit');
Route::post('/warehouse', 'WarehouseController@store');
Route::put('/warehouse/update/{id}', 'WarehouseController@update');
Route::delete('/warehouse/delete/{id}', 'WarehouseController@destroy');