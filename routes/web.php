<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConvertController;


Route::get('/', function () {
    return view('convert');
});

Route::get('/convert', function () {
    return view('convert');
});

Route::post('/convert', [ConvertController::class, 'convert'])->name('convert');
