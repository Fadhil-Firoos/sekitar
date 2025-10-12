<?php

use Illuminate\Support\Facades\Route;

// Halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Halaman khusus sekitarmu (juga load welcome.blade.php)
Route::get('/sekitarmu', function () {
    return view('welcome');
})->name('sekitarmu');



