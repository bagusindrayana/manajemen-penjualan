<?php

use App\Models\Sale;
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


Route::get('/invoice/{id}', function ($id) {
    $sale = Sale::with('items.product')->find($id);
    return view('invoice',compact('sale'));
})->name('print-invoice');


Route::get('/', function () {
    return redirect('/admin');
});
