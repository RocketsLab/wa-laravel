<?php

namespace RocketsLab\WALaravel\Concerns;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

trait HasSession
{
    protected string $session;

    public function defineSession($sessionName): self
    {
        $this->session = $sessionName;
        return $this;
    }

    public function startSession(string $sessionName, bool $isLegacy = false): Response
    {
        //TODO: try catch and check response
        return Http::post("{$this->host}:{$this->port}/session/add", [
            'id' => $sessionName,
            'isLegacy' => $isLegacy
        ]);
    }

    /**
     * @throws \RocketsLab\WALaravel\Exceptions\SessionNotDefined
     */
    public function removeSession(string $session = null): Response
    {
        $currentSession = $session ?? $this->session;

        $this->checkForSession($currentSession);

        //TODO: try catch and check response
        return Http::delete("{$this->host}:{$this->port}/session/delete/{$currentSession}");
    }
}
