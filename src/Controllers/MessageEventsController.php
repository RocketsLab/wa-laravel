<?php

namespace RocketsLab\WALaravel\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use RocketsLab\WALaravel\Concerns\HasEventData;
use RocketsLab\WALaravel\Events\MessageUpsert;

class MessageEventsController extends Controller
{
    use HasEventData;

    public function upsert(Request $request)
    {
        event(new MessageUpsert(...$this->buildEventData($request)));
    }
}
