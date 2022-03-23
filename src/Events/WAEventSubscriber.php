<?php

namespace RocketsLab\WALaravel\Events;

use Illuminate\Support\Str;

class WAEventSubscriber
{
    public function handleEvent($event)
    {
        $this->broadcastEvent(Str::kebab(class_basename($event)), $event);
    }

    public function subscribe($events)
    {
        return [
            ConnectionOpen::class => 'handleEvent',
            ConnectionClosed::class => 'handleEvent',
            ConnectionUpdated::class => 'handleEvent',
            ConnectionConnecting::class => 'handleEvent',
            ConnectionQrcode::class => 'handleEvent',
            MessageUpsert::class => 'handleEvent'
        ];
    }

    protected function broadcastEvent(string $eventName, mixed $event)
    {
        WAEventBroadcaster::broadcast($eventName, $event);
    }
}
