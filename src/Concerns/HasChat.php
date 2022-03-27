<?php
namespace RocketsLab\WALaravel\Concerns;

use Illuminate\Support\Facades\Http;

trait HasChat
{
    public function fromChat()
    {
        $this->from = 'chat';

        return $this;
    }
}
