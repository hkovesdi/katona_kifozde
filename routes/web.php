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
    Route::get('/', function() {
        return redirect()->route('megrendelesek', ['user' => Auth::user()]);
    })->name('home');

    Route::group(['middleware' => 'isFonokOrTitkarno'], function () {
        Route::get('/tetelek/{evHet?}', 'TetelController@show')->name('tetelek');
        Route::get('/megrendelok', 'MegrendeloController@show')->name('megrendelok');
        Route::post('/megrendelok/{megrendelo}', 'MegrendeloController@modositas')->name('megrendeloModositas');
        Route::post('/tetel-ar-modositas', 'TetelController@tetelArModositas')->name('tetelArModositas');
        Route::post('/felhasznalo-letrehozas', 'UserController@create')->name('felhasznaloLetrehozas');
    });
    Route::group(['middleware' => 'isNotKiszallito'], function() {
        Route::get('/nyomtatvanyok', 'NyomtatvanyController@show')->name('nyomtatvanyok');
        Route::get('/nyomtatvanyok/szakacs-osszesito/{datum}', 'NyomtatvanyController@showSzakacsView')->name('nyomtatvanyok.szakacsView');
        Route::get('/nyomtatvanyok/futar-heti/{kiszallito}/{evHet}', 'NyomtatvanyController@showFutarHeti')->name('nyomtatvanyok.futarHeti');
        Route::get('/nyomtatvanyok/osszesito/{kezdete}/{vege}', 'NyomtatvanyController@showOsszesito')->name('nyomtatvanyok.osszesito');
    });
    Route::get('/megrendelesek/{user}/{evHet?}', 'MegrendelesController@show')->name('megrendelesek');
    Route::get('/megrendeles-table/{megrendeloHet}', 'MegrendelesController@showMegrendelesTable')->name('megrendelesTable');
    Route::post('/megrendelo-het/kedvezmeny-modositas/{megrendeloHet}', 'MegrendelesController@kedvezmenyValtoztatas')->name('kedvezmenyValtoztatas');
    Route::post('megrendelo-het-sorrend-modositas/{user}', 'MegrendelesController@sorrendModositas')->name('sorrendModositas');
    Route::post('megrendelo-het-torles/{user}', 'MegrendelesController@megrendeloHetTorles')->name('megrendeloHetTorles');
    Route::post('/jelszo-valtoztatas', 'UserController@jelszoValtoztatas')->name('jelszoValtoztatas');
    Route::post('/megrendeles-modositas', 'MegrendelesController@modositas')->name('megrendelesModositas');
    Route::post('/megrendelo-letrehozas', 'MegrendeloController@letrehozas')->name('megrendeloLetrehozas');
    Route::post('/megrendelo-het-letrehozas/{user}/{megrendelo}', 'MegrendelesController@megrendeloHetLetrehozas')->name('megrendeloHetLetrehozas');
    Route::post('/logout', 'LoginController@logout')->name('logout');
    Route::post('/fizetesi-statusz-modositas/{megrendeloHet}', 'MegrendelesController@changeFizetesiStatusz')->name('fizetesiStatuszModositas');
});
Route::get('/login', 'LoginController@show')->name('login');
Route::post('/login', 'LoginController@authenticate')->name('login');
