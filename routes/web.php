<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/filament-optimize', function () {
    return Artisan::call('make:optimize');
});

Route::get('/filament-optimize-clear', function () {
    return Artisan::call('make:optimize-clear');
});


Route::get('/', function () {
    return redirect('/admin');
});
