<?php

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;


Route::get('/admin','App\Http\Controllers\AdminController@index');
Route::get('/admin/{id}','App\Http\Controllers\AdminController@show');
Route::post('/admin','App\Http\Controllers\AdminController@store');
Route::put('/admin/{id}','App\Http\Controllers\AdminController@update');
Route::delete('/admin/{id}','App\Http\Controllers\AdminController@destroy');
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
<<<<<<< HEAD
Route::get('/etudiant', 'App\Http\Controllers\EtudiantController@index');
Route::post('/etudiant', 'App\Http\Controllers\EtudiantController@store');
Route::get('/etudiant/{id}', 'App\Http\Controllers\EtudiantController@show');
Route::post('/etudiant/{id}', 'App\Http\Controllers\EtudiantController@update');
Route::delete('/etudiant/{id}', 'App\Http\Controllers\EtudiantController@destroy');
=======


/** Enseignant */
Route::get('/enseignant', 'App\Http\Controllers\EnseignantController@index');
Route::post('/enseignant', 'App\Http\Controllers\EnseignantController@store');
Route::get('/enseignant/{id}', 'App\Http\Controllers\EnseignantController@show');
Route::post('/enseignant/{id}', 'App\Http\Controllers\EnseignantController@update');
Route::delete('/enseignant/{id}', 'App\Http\Controllers\EnseignantController@destroy');


>>>>>>> main
