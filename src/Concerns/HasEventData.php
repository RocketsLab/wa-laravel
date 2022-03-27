<?php

namespace RocketsLab\WALaravel\Concerns;

use Illuminate\Http\Request;

trait HasEventData
{
    protected function buildEventData(Request $request): array
    {
        return $request->only(['instance', 'type', 'data']);
    }
}
