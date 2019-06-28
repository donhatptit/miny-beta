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

//Route::group();

include __DIR__ . "/frontend.php";


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/chitiet/{id}', 'HomeController@detail')->name('demopost.manager');
Route::get('document/show/{filename}/{folder?}', 'MediaController@showFile')->name('show.filename');
Route::get('document/image/{filename}', 'MediaController@showImage')->name('show.image');