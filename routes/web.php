<?php

use BeyondCode\LaravelWebSockets\Facades\WebSocketsRouter;

WebSocketsRouter::webSocket('wasocket', config('walaravel.websocket.handler'));
