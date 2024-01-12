<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\DataController;
Route::get('/', function () {
    return view('welcome');
});
Route::post('/upload', [DataController::class, 'upload']);
Route::get('/show', [DataController::class, 'show']);
Route::get('/display/{folder}/{file}', FileController::class);