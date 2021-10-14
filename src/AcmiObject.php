<?php

namespace Kavinsky\TacviewAcmiParser;

use Illuminate\Support\Collection;

class AcmiObject
{
    public Collection $log;

    public AcmiPropertyBag $properties;

    public function __construct()
    {
        $this->log = collect();
        $this->properties = new AcmiPropertyBag();
    }
}
