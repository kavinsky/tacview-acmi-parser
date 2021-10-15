<?php

namespace Kavinsky\TacviewAcmiParser\Collections;

use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use Kavinsky\TacviewAcmiParser\AcmiEventRecord;
use Kavinsky\TacviewAcmiParser\AcmiObject;
use Kavinsky\TacviewAcmiParser\AcmiObjectRecord;
use Kavinsky\TacviewAcmiParser\AcmiRecord;

class AcmiLogCollection extends Collection
{
    /**
     * @param  string  $id
     * @return AcmiLogCollection
     */
    public function byObjectId(string $id): AcmiLogCollection
    {
        return $this->filter(function (AcmiRecord $item) use ($id) {
            return $item instanceof AcmiObjectRecord && $id === $item->objectId;
        });
    }

    /**
     * @param  AcmiObject  $object
     * @return AcmiLogCollection
     */
    public function byObject(AcmiObject $object): AcmiLogCollection
    {
        return $this->byObjectId($object->id);
    }

    /**
     * @param  string  $name
     * @return AcmiLogCollection
     */
    public function byEventName(string $name): AcmiLogCollection
    {
        return $this->filter(function (AcmiRecord $item) use ($name) {
            return $item instanceof AcmiEventRecord && $name === $item->name;
        });
    }

    /**
     * @param  CarbonInterface  $date
     * @return AcmiLogCollection
     */
    public function laterThan(CarbonInterface $date): AcmiLogCollection
    {
        return $this->filter(function (AcmiRecord $item) use ($date) {
            return $item->timestamp()->greaterThan($date);
        });
    }

    /**
     * @param  CarbonInterface  $date
     * @return AcmiLogCollection
     */
    public function earlierThan(CarbonInterface $date): AcmiLogCollection
    {
        return $this->filter(function (AcmiRecord $item) use ($date) {
            return $item->timestamp()->lessThan($date);
        });
    }
}
