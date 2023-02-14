<?php

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;

/** admin */
Route::get('/admin','App\Http\Controllers\AdminController@index')->middleware('auth:sanctum');
Route::get('/admin/{id}','App\Http\Controllers\AdminController@show');
Route::post('/admin','App\Http\Controllers\AdminController@store');
Route::post('/admin/{id}','App\Http\Controllers\AdminController@update');
Route::delete('/admin/{id}','App\Http\Controllers\AdminController@destroy');
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/** Etudiant*/
Route::get('/etudiant', 'App\Http\Controllers\EtudiantController@index');
Route::post('/etudiant', 'App\Http\Controllers\EtudiantController@store');
Route::get('/etudiant/{id}', 'App\Http\Controllers\EtudiantController@show');
Route::post('/etudiant/{id}', 'App\Http\Controllers\EtudiantController@update');
Route::delete('/etudiant/{id}', 'App\Http\Controllers\EtudiantController@destroy');

/** Enseignant */
Route::get('/enseignant', 'App\Http\Controllers\EnseignantController@index');
Route::post('/enseignant', 'App\Http\Controllers\EnseignantController@store');
Route::get('/enseignant/{id}', 'App\Http\Controllers\EnseignantController@show');
Route::post('/enseignant/{id}', 'App\Http\Controllers\EnseignantController@update');
Route::delete('/enseignant/{id}', 'App\Http\Controllers\EnseignantController@destroy');

//authentification
Route::post('/auth/register','App\Http\Controllers\Api\AuthController@createUser');
Route::post('/auth/login',  'App\Http\Controllers\Api\AuthController@loginUser');
