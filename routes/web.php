<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('docsapi', function () {
    return view('vendor.l5-swagger.index');
});
