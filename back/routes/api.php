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


/** Enseignant */
Route::get('/enseignant', 'App\Http\Controllers\EnseignantController@index');
Route::post('/enseignant', 'App\Http\Controllers\EnseignantController@store');
Route::get('/enseignant/{id}', 'App\Http\Controllers\EnseignantController@show');
Route::post('/enseignant/{id}', 'App\Http\Controllers\EnseignantController@update');
Route::delete('/enseignant/{id}', 'App\Http\Controllers\EnseignantController@destroy');


