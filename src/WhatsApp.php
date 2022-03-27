<?php

namespace RocketsLab\WALaravel;

use RocketsLab\WALaravel\Concerns\Common;
use RocketsLab\WALaravel\Concerns\HasGroup;
use RocketsLab\WALaravel\Concerns\HasMessage;
use RocketsLab\WALaravel\Concerns\HasChat;
use RocketsLab\WALaravel\Concerns\HasSession;

final class WhatsApp
{
    use Common,
        HasMessage,
        HasChat,
        HasGroup,
        HasSession;

    protected string $host;

    protected string $port;

    protected string $from = 'chat';

    public static function factory(): self {
        $instance = new WhatsApp;
        $instance->host = config('walaravel.host');
        $instance->port = config('walaravel.port');
        return $instance;
    }

    public function getCurrentFrom(): string
    {
        return $this->from;
    }
}
