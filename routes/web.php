<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/filament-optimize', function () {
    return Artisan::call('filament:optimize');
});

Route::get('/filament-optimize-clear', function () {
    return Artisan::call('filament:optimize-clear');
});

Route::get('/migrate', function () {
    return Artisan::call('migrate');
});

Route::get('/db-seed', function () {
    return Artisan::call('db:seed');
});



Route::get('/', function () {
    return redirect('/admin');
});
