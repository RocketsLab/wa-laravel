<?php

use Illuminate\Support\Facades\Route;
use RocketsLab\WALaravel\Controllers\ConnectionEventsController;

Route::group(['prefix' => 'wahook'], function () {

    Route::post('connection/open', [ConnectionEventsController::class, 'open']);

    Route::post('connection/close', [ConnectionEventsController::class, 'close']);

    Route::post('connection/connecting', [ConnectionEventsController::class, 'connecting']);

    Route::post('connection/qrcode', [ConnectionEventsController::class, 'qrcode']);

});
