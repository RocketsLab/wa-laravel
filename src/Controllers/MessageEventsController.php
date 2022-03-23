<?php

namespace RocketsLab\WALaravel\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use RocketsLab\WALaravel\Events\MessageUpsert;

class MessageEventsController extends Controller
{
    public function upsert(Request $request)
    {
        event(new MessageUpsert(...$this->buildEventData($request)));
    }

    protected function buildEventData(Request $request): array
    {
        return $request->only(['instance', 'type', 'data']);
    }
}
