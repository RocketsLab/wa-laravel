<?php

namespace RocketsLab\WALaravel\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use RocketsLab\WALaravel\Events\ConnectionClosed;
use RocketsLab\WALaravel\Events\ConnectionConnecting;
use RocketsLab\WALaravel\Events\ConnectionOpen;
use RocketsLab\WALaravel\Events\ConnectionQrcode;

class ConnectionEventsController extends Controller
{
    public function close(Request $request)
    {
        event(new ConnectionClosed(...$this->buildEventData($request)));
    }

    public function open(Request $request)
    {
        event(new ConnectionOpen(...$this->buildEventData($request)));
    }

    public function connecting(Request $request)
    {
        event(new ConnectionConnecting(...$this->buildEventData($request)));
    }

    public function qrcode(Request $request)
    {
        event(new ConnectionQrcode(...$this->buildEventData($request)));
    }

    protected function buildEventData(Request $request): array
    {
        return $request->only(['instance', 'type', 'data']);
    }
}
