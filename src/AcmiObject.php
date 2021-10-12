<?php

namespace Kavinsky\TacviewAcmiReader;

use Illuminate\Support\Collection;

class AcmiObject
{
    public Collection $transformationLog;

    public function __construct()
    {
        $this->transformationLog = collect();
    }
}
