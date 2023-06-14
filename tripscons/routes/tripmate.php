<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:api'], function () {
    Route::post("image", [\App\Http\Controllers\Api\TripmatesController::class, "uploadImage"]);
});
