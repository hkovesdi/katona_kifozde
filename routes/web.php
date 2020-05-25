<?php

use Illuminate\Support\Facades\Route;

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
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'MegrendelesController@show')->name('home');
    Route::post('/megrendeles-modositas', 'MegrendelesController@modositas')->name('megrendelesModositas');
    Route::post('/logout', 'LoginController@logout')->name('logout');
    Route::get('/nyomtatvanyok', 'NyomtatvanyController@show')->name('nyomtatvanyok');
    Route::get('/nyomtatvanyok/szakacs-osszesito/{datum}', 'NyomtatvanyController@showSzakacsView')->name('nyomtatvanyok.szakacsView');
    Route::get('/nyomtatvanyok/futar-heti', 'NyomtatvanyController@showFutarHeti')->name('nyomtatvanyok.futarHeti');
});
Route::get('/login', 'LoginController@show')->name('login');
Route::post('/login', 'LoginController@authenticate')->name('login');
