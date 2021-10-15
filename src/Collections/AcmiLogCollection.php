<?php

namespace Kavinsky\TacviewAcmiParser\Collections;

use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use Kavinsky\TacviewAcmiParser\AcmiObject;

class AcmiLogCollection extends Collection
{
    public function byObjectId(string $id): AcmiLogCollection
    {
        return $this;
    }

    public function byObject(AcmiObject $object): AcmiLogCollection
    {
        return $this;
    }

    public function byEventName(string $name): AcmiLogCollection
    {
        return $this;
    }

    public function laterThan(CarbonInterface $date): AcmiLogCollection
    {
        return $this;
    }

    public function earlierThan(CarbonInterface $date): AcmiLogCollection
    {
        return $this;
    }
}
