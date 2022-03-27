<?php
namespace RocketsLab\WALaravel\Concerns;

use Illuminate\Support\Facades\Http;

trait HasGroup
{
    public function fromGroup()
    {
        $this->from = 'group';

        return $this;
    }
}
