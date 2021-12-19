<?php
use App\Http\Controllers\Auth\AuthController;
Route::prefix('{locale}/v1/auth')->where(['locale' => '[a-zA-Z]{2}'])
    ->middleware(['localization'])
    ->group(function () {
        Route::post('registraion', [AuthController::class, 'registration']);
        Route::post('login', [AuthController::class, 'login']);
        Route::get('me', [AuthController::class, 'me']);
        Route::post('logout', [AuthController::class, 'logout']);
    });