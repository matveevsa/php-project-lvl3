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
Route::get('/domains', 'DomainsController@index')->name('domains.index');

Route::post('/domains', 'DomainsController@store')->name('domains.store');

Route::get('/domains/{id}', 'DomainsController@show')->name('domains.show');

Route::post('/domains/{id}/checks', 'DomainsController@checks')->name('domains.checks');

Route::get('/', fn() => view('create'));
