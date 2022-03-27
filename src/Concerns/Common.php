<?php

namespace RocketsLab\WALaravel\Concerns;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use RocketsLab\WALaravel\Exceptions\SessionNotDefined;

trait Common
{
    /**
     * @throws SessionNotDefined
     */
    public function list(string $session = null): Response
    {
        $currentSession = $session ?? $this->session;

        $this->checkForSession($currentSession);

        //TODO: try catch and check response
        return Http::get("{$this->host}:{$this->port}/{$this->from}/get?id={$currentSession}");
    }

    /**
     * @throws SessionNotDefined
     */
    public function conversation(
        string $remoteJid,
        int $limit = 25,
        string $cursorId = 'REDACTED',
        bool $fromMe = false,
        string $session = null): Response
    {
        $currentSession = $session ?? $this->session;

        $this->checkForSession($currentSession);

        $queryString = "limit={$limit}&cursor_id={$cursorId}&cursor_fromMe={$fromMe}";

        return Http::get("{$this->host}:{$this->port}/{$this->from}/get/{$remoteJid}?id={$currentSession}&{$queryString}");
    }

    /**
     * @throws SessionNotDefined
     */
    public function checkForSession(string $session)
    {
        if(empty($session)) {
            throw new SessionNotDefined("No session defined. Start a session using 'startSession' method.");
        }
    }
}
