<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    phpinfo();
    return view('welcome');
});


