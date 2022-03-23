<?php

use Illuminate\Support\Facades\Route;
use RocketsLab\WALaravel\Controllers\MessageEventsController;

Route::group(['prefix' => 'wahook'], function () {

    Route::post('messages/upsert', [MessageEventsController::class, 'upsert']);

});
