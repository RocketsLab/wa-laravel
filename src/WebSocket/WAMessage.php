<?php

namespace RocketsLab\WALaravel\WebSocket;

interface WAMessage
{
    public function respond();

    public function getPayload();
}
