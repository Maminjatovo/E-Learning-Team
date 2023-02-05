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
Route::get('/etudiant', 'App\Http\Controllers\EtudiantController@index');
Route::post('/etudiant', 'App\Http\Controllers\EtudiantController@store');
Route::get('/etudiant/{id}', 'App\Http\Controllers\EtudiantController@show');
Route::post('/etudiant/{id}', 'App\Http\Controllers\EtudiantController@update');
Route::delete('/etudiant/{id}', 'App\Http\Controllers\EtudiantController@destroy');
