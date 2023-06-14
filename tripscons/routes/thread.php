<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:api'], function () {
    Route::post("message", [\App\Http\Controllers\Api\Thread\MessagesController::class, "create"]);

    Route::post("openThread", [\App\Http\Controllers\Api\Thread\MessagesController::class, "openThread"]);

    Route::post("file", [\App\Http\Controllers\Api\Thread\MessagesController::class, "uploadFile"]);
    Route::post("broadcast-message", [\App\Http\Controllers\Api\Thread\MessagesController::class, "message"]);
    Route::get("get", [\App\Http\Controllers\Api\Thread\MessagesController::class, "getThreads"]);
    Route::get("message/{thread}", [\App\Http\Controllers\Api\Thread\MessagesController::class, "getMessages"]);

});
