<?php

namespace RocketsLab\WALaravel;

use Illuminate\Support\Facades\Http;
use RocketsLab\WALaravel\Concerns\WAMessage;

class WhatsApp
{
    use WAMessage;

    protected string $host;

    protected string $port;

    protected string $session;

    public static function factory() {
        $instance = new static;
        $instance->host = config('walaravel.host');
        $instance->port = config('walaravel.port');
        return $instance;
    }

    public function defineSession($sessionName): self
    {
        $this->session = $sessionName;
        return $this;
    }

    public function start(string $sessionName, bool $isLegacy = false)
    {
        //TODO: try catch and check response
        return Http::post("{$this->host}:{$this->port}/session/add", [
            'id' => $sessionName,
            'isLegacy' => $isLegacy
        ]);
    }

    public function removeSession(string $session = null)
    {
        $currentSession = $session ?? $this->session;
        //TODO: try catch and check response
        return Http::delete("{$this->host}:{$this->port}/session/delete/{$currentSession}");
    }
}
