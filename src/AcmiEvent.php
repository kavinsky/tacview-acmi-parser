<?php

namespace Kavinsky\TacviewAcmiReader;

use Carbon\Carbon;

class AcmiEvent
{
    public Carbon $time;

    public string $name;

    public array $payload;

    public function __construct(Carbon $time, string $name, array $payload = [])
    {
        $this->time = $time;
        $this->name = $name;
        $this->payload = $payload;
    }
}
