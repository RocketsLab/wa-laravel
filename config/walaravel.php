<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Node server host
    |--------------------------------------------------------------------------
    | If environment WA_HOST not set its used the APP_URL environment value,
    | if APP_URL not set, localhost will be used
    |
    */
    'host' => env('WA_HOST', env('APP_URL', 'localhost')),

    'secure' => env('WA_SECURE', false),

    /*
    |--------------------------------------------------------------------------
    | Node server port
    |--------------------------------------------------------------------------
    | You can specify the WhatsApp server listen port
    |
    */
    'port' => env('WA_PORT', 3333),

    /*
    |--------------------------------------------------------------------------
    | Self register events
    |--------------------------------------------------------------------------
    | By default this option is set true to automatic event registration.
    | The WALaravel events will be triggered by WAEventBroadcaster passing the
    | event name and the event data from 'walaravel' channel
    |
    | If you desire create your own event listeners and event broadcasting
    | set this option to false
    |
    */
    'register_events' => env('WA_REGISTER_EVENTS', true),

    /*
    |--------------------------------------------------------------------------
    | Maxinum reconnection retries attempts
    |--------------------------------------------------------------------------
    | WAServer will retry the amount of times to reconnect with WhatsApp web
    | instance and the cellphone synchronized
    |
    */
    'max_retries' => env('WA_MAX_RETRIES', 5),

    /*
    |--------------------------------------------------------------------------
    | Reconnection time interval
    |--------------------------------------------------------------------------
    | Sets the amount of time between reconnection retries.
    | This value its in milliseconds
    |
    */
    'reconnect_interval' => env('WA_RECONNECT_INTERVAL', 5000),

    /*
    |--------------------------------------------------------------------------
    | Communication Protocol
    |--------------------------------------------------------------------------
    |
    |
    |
    */
    'protocol' => env('WA_PROTOCOL', 'webhook'),

    /*
    |--------------------------------------------------------------------------
    | Communication Protocol
    |--------------------------------------------------------------------------
    |
    |
    |
    */
    'websocket' => [
        'host' => env('WA_WSHOST', 'localhost'),
        'port' => env('WA_WSPORT', 6001),
        'handler' => \RocketsLab\WALaravel\WebSocket\WebSocketHandler::class,
        'end_point' => env('WA_WSENDPOINT', 'wasocket')
    ],

];
