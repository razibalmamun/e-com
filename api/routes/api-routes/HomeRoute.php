<?php
use App\Http\Controllers\DefaultController;
Route::prefix('{locale}/v1/catalog/')->where(['locale' => '[a-zA-Z]{2}'])
    ->middleware(['localization'])
    ->group(function () {
        Route::get('products', [DefaultController::class, 'index']);
});