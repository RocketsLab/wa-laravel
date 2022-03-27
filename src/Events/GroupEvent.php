<?php

namespace RocketsLab\WALaravel\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

abstract class GroupEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string|null $instance;
    public string|null $type;
    public array $data;

    public function __construct(string|null $instance = null, string|null $type = null, array $data = [])
    {
        $this->instance = $instance;
        $this->type = $type;
        $this->data = $data;
    }
}
