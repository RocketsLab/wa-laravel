<?php

namespace RocketsLab\WALaravel\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use RocketsLab\WALaravel\Concerns\HasEventData;
use RocketsLab\WALaravel\Events\GroupsParticipants;
use RocketsLab\WALaravel\Events\GroupsUpdate;

class GroupsEventsController extends Controller
{
    use HasEventData;

    public function update(Request $request)
    {
        event(new GroupsUpdate(...$this->buildEventData($request)));
    }

    public function participants(Request $request)
    {
        event(new GroupsParticipants(...$this->buildEventData($request)));
    }
}
