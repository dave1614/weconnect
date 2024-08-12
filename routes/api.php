<?php

use App\Http\Controllers\ProvidusController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');





Route::any('/receive_payscribe_webhooks', [ProvidusController::class, 'recievePayscribeWebhooks']);
Route::any('/receive_providus_webhooks', [ProvidusController::class, 'recieveProvidusWebhooks']);
Route::any('/receive_monnify_webhooks', [ProvidusController::class, 'recieveMonnifyWebhooks']);
