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
    return view('index');
});
Route::post('/upload','ImageController@store')->name('image.upload');
Route::get('/refreshTable','ImageController@refreshTable')->name('image.refreshTable');
Route::get('/addImage','ImageController@addImage')->name('image.addImage');
Route::delete('/delImage/{key}','ImageController@delImage')->name('image.delete');
