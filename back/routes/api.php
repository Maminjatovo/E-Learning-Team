<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


/** Enseignant */
Route::get('/enseignant', 'App\Http\Controllers\EnseignantController@index');
Route::post('/enseignant', 'App\Http\Controllers\EnseignantController@store');
Route::get('/enseignant/{id}', 'App\Http\Controllers\EnseignantController@show');
Route::post('/enseignant/{id}', 'App\Http\Controllers\EnseignantController@update');
Route::delete('/enseignant/{id}', 'App\Http\Controllers\EnseignantController@destroy');


