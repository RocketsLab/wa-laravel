<?php

namespace RocketsLab\WALaravel\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WAEventBroadcaster implements ShouldBroadcastNow
{
    use Dispatchable,
        InteractsWithSockets,
        SerializesModels;

    public mixed $event;

    protected string $broadcastAs;

    /**
     * Create a new event instance.
     *
     * @param string $broadcastAs - Name of Broadcasting this event as
//     * @param array $data - The event Data
     * @param mixed $event - Emitted event
     * @return void
     */
    public function __construct(string $broadcastAs, mixed $event)
    {
        //
        $this->broadcastAs = $broadcastAs;
        $this->event = $event;
    }

    public function broadcastOn()
    {
        return new Channel("walaravel.{$this->event->instance}");
    }

    public function broadcastAs()
    {
        return "{$this->broadcastAs}";
    }
}
