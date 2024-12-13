<?php

use App\Http\Controllers\ProvidusController;
use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::any('/test', [TestController::class, 'apiTest']);

Route::any('/receive_payscribe_webhooks', [ProvidusController::class, 'recievePayscribeWebhooks']);
Route::any('/receive_providus_webhooks', [ProvidusController::class, 'recieveProvidusWebhooks']);
Route::any('/receive_monnify_webhooks', [ProvidusController::class, 'recieveMonnifyWebhooks']);

Route::any('/apply_as_community_leader/{user}', [TestController::class, 'applyAsCommunityLeader']);
