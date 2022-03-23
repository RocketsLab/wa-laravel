<?php

namespace RocketsLab\WALaravel\WebSocket;

use Illuminate\Support\Str;
use Ratchet\ConnectionInterface;
use RocketsLab\WALaravel\Events\ConnectionClosed;
use RocketsLab\WALaravel\Events\ConnectionConnecting;
use RocketsLab\WALaravel\Events\ConnectionOpen;
use RocketsLab\WALaravel\Events\ConnectionQrcode;
use stdClass;

class WAChannelProtocolMessage implements WAMessage
{
    /** @var \stdClass */
    protected $payload;

    /** @var \React\Socket\ConnectionInterface */
    protected $connection;

    public function __construct(stdClass $payload, ConnectionInterface $connection)
    {
        $this->payload = $payload;

        $this->connection = $connection;
    }

    public function respond()
    {
        $eventName = Str::camel(Str::after($this->payload->event, ':'));

        if (method_exists($this, $eventName) && $eventName !== 'respond') {
            \Log::alert(json_encode($this->payload));
            call_user_func([$this, $eventName], $this->connection, $this->payload ?? new stdClass());
        }
    }

    protected function ping(ConnectionInterface $connection)
    {
        $connection->send(json_encode([
            'event' => 'wa:pong'
        ]));
    }

    protected function connectionQrcode(ConnectionInterface $connection, stdClass $payload)
    {
        \Log::alert("QRCODE FOUND!");
        ConnectionQrcode::dispatch($payload->sessionId, null, [
            'image' => $payload->image
        ]);

        $connection->send(json_encode([
            'event' => 'wa:respond',
            'data' => 'OK'
        ]));
    }

    protected function connectionOpen(ConnectionInterface $connection, stdClass $payload)
    {
        ConnectionOpen::dispatch($payload->sessionId);

        $connection->send(json_encode([
            'event' => 'wa:respond',
            'data' => 'OK'
        ]));
    }

    protected function connectionClosed(ConnectionInterface $connection, stdClass $payload)
    {
        ConnectionClosed::dispatch($payload->sessionId);

        $connection->send(json_encode([
            'event' => 'wa:respond',
            'data' => 'OK'
        ]));
    }

    protected function connectionConnecting(ConnectionInterface $connection, stdClass $payload)
    {
        $connection->send(json_encode([
            'event' => 'wa:respond',
            'data' => 'OK'
        ]));

        ConnectionConnecting::dispatch($payload->sessionId);
    }

    protected function connectionEstablished(ConnectionInterface $connection, stdClass $payload)
    {
        $connection->send(json_encode([
            'event' => 'wa:respond',
            'data' => 'OK'
        ]));
    }

    public function getPayload()
    {
        return $this->payload;
    }

    public function __toString(): string
    {
        return json_encode($this->payload);
    }
}
