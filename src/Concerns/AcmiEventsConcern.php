<?php

namespace Kavinsky\TacviewAcmiReader\Concerns;

use Illuminate\Support\Collection;
use Kavinsky\TacviewAcmiReader\AcmiEvent;

trait AcmiEventsConcern
{
    /**
     * @var Collection<AcmiEvent>
     */
    public Collection $events;
}
