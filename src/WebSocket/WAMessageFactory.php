<?php

namespace RocketsLab\WALaravel\WebSocket;

use Illuminate\Support\Str;
use JetBrains\PhpStorm\Pure;
use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;

class WAMessageFactory
{
    public static function createForMessage(MessageInterface $message, ConnectionInterface $connection)
    : WAChannelProtocolMessage|\stdClass
    {
        $payload = json_decode($message->getPayload());

        return Str::startsWith($payload->event, 'wa:') ?
            new WAChannelProtocolMessage($payload, $connection) :
            self::createGenericMessage($payload, $connection);
    }

    #[Pure]
    protected static function createGenericMessage($payload, $connection): \stdClass
    {
        $generic = new \stdClass();
        $generic->payload = $payload;
        $generic->connection = $connection;
        $generic->respond = fn() => $connection->send(json_encode(['event' => 'generic']));

        return $generic;
    }
}
