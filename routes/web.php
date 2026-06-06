<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


// ❌ keep this LAST so it doesn't swallow everything
Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');