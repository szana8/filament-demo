<?php

use App\Http\Controllers\Auth\TwoFactorQrCodeController;
use App\Http\Controllers\Auth\AuthTwoFAController;
use App\Http\Controllers\Auth\RecoveryCodeController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', static function (Request $request) {
    return array_merge($request->user()->toArray(), []);
})->middleware('auth:api');