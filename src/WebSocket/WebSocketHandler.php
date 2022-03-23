<?php

namespace RocketsLab\WALaravel\WebSocket;

use BeyondCode\LaravelWebSockets\Apps\App;
use BeyondCode\LaravelWebSockets\QueryParameters;
use BeyondCode\LaravelWebSockets\WebSockets\WebSocketHandler as BaseHandler;
use Illuminate\Support\Str;
use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;

class WebSocketHandler extends BaseHandler
{
    /**
     * @param ConnectionInterface $connection
     * @return void
     * @throws \BeyondCode\LaravelWebSockets\Exceptions\InvalidApp
     * @throws \BeyondCode\LaravelWebSockets\WebSockets\Exceptions\ConnectionsOverCapacity
     * @throws \BeyondCode\LaravelWebSockets\WebSockets\Exceptions\UnknownAppKey
     */
    function onOpen(ConnectionInterface $connection)
    {
        $this->generateSocketId($connection)
            ->verifyAppKey($connection)
            ->limitConcurrentConnections($connection)
            ->establishConnection($connection);
    }

    public function onMessage(ConnectionInterface $connection, MessageInterface $message)
    {
        $message = WAMessageFactory::createForMessage($message, $connection);

        $message->respond();

//        \Log::info("MSG: " . $message->getPayload() . " - FROM: ". $connection->app->id);
    }

    protected function establishConnection(ConnectionInterface $connection): WebSocketHandler|static
    {
        $connection->send(json_encode([
            'event' => 'wa:connection_established',
            'data' => [
                'socket_id' => $connection->socketId,
                'activity_timeout' => 30,
            ]
        ]));

        return $this;
    }

    /**
     * @throws \BeyondCode\LaravelWebSockets\Exceptions\InvalidApp
     */
    protected function verifyAppKey(ConnectionInterface $connection)
    {
        $appKey = QueryParameters::create($connection->httpRequest)->get('appKey');
        $appId = QueryParameters::create($connection->httpRequest)->get('appId');

        $connection->app = new App($appId, $appKey, Str::random());

        $connection->app->statisticsEnabled = false;
        $connection->app->clientMessagesEnabled = false;

        return $this;
    }
}
