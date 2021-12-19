<?php
use App\Http\Controllers\Admin\OrderController;
Route::prefix('{locale}/v1/admin/')->where(['locale' => '[a-zA-Z]{2}'])
    ->middleware(['localization', 'auth:api'])
    ->group(function () {
        Route::get('orders', [OrderController::class, 'index']);
        Route::get('orders/{order}', [OrderController::class, 'show']);
        Route::post('orders', [OrderController::class, 'store']);
        Route::put('orders/{order}', [OrderController::class, 'update']);
        Route::delete('orders/{order}', [OrderController::class, 'delete']);
});