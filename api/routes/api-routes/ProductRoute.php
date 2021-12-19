<?php
use App\Http\Controllers\Admin\ProductController;
Route::prefix('{locale}/v1/')->where(['locale' => '[a-zA-Z]{2}'])
    ->middleware(['localization', 'auth:api'])
    ->group(function () {
        Route::get('products', [ProductController::class, 'index']);
        Route::get('products/{product}', [ProductController::class, 'show']);
        Route::post('products', [ProductController::class, 'store']);
        Route::put('products/{product}', [ProductController::class, 'update']);
        Route::delete('products/{product}', [ProductController::class, 'delete']);
});