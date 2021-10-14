<?php

namespace Kavinsky\TacviewAcmiReader\Concern;

use Illuminate\Support\Collection;
use Kavinsky\TacviewAcmiReader\AcmiEvent;

trait AcmiEventsConcern
{
    /**
     * @var Collection<AcmiEvent>
     */
    public Collection $events;
}
