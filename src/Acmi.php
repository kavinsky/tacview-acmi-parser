<?php

namespace Kavinsky\TacviewAcmiReader;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Kavinsky\TacviewAcmiReader\Concern\AcmiEventsConcern;
use Kavinsky\TacviewAcmiReader\Concern\AcmiGlobalPropertiesConcern;

/**
 * The ACMI Report Object
 *
 * @see https://www.tacview.net/documentation/acmi/en/
 */
class Acmi
{
    use AcmiGlobalPropertiesConcern;
    use AcmiEventsConcern;

    /**
     * @var Collection<AcmiObject>
     */
    public Collection $objects;

    public function __construct()
    {
        $this->events = collect();
        $this->objects = collect();
    }

    /**
     * A helper method to return a DateTimeInterface with added delta from referenceTime.
     *
     * @param  float|int  $delta
     * @return Carbon
     */
    public function getPlusDelta(float|int $delta = 0): Carbon
    {
        return $this->referenceTime->clone()->addMicroseconds(
            $delta * 1000
        );
    }
}
