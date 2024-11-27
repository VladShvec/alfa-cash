<?php

use App\Http\Controllers\CurrencyController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'currencies',
    'as' => 'currencies.'
    ], function () {
    Route::get('you-receive/{currency}', [CurrencyController::class, 'getYouReceiveCurrencies']);
    Route::get('you-give', [CurrencyController::class, 'getYouGiveCurrencies']);
    Route::post('convert', [CurrencyController::class, 'convertCurrencies']);
});
