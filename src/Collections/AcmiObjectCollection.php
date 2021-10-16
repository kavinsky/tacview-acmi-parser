<?php

namespace Kavinsky\TacviewAcmiParser\Collections;

use Illuminate\Support\Collection;
use Kavinsky\TacviewAcmiParser\AcmiObject;
use Kavinsky\TacviewAcmiParser\Enum\AcmiObjectType;

/**
 * @psalm-template TKey string
 * @psalm-template TValue AcmiObject
 */
class AcmiObjectCollection extends Collection
{
    /**
     * Filter the objects by the given Type
     *
     * @param  AcmiObjectType|array  $types
     * @return $this
     */
    public function byType(AcmiObjectType|array $types): self
    {
        return $this->filter(function (AcmiObject $item) use ($types) {
            return $item->types->is($types);
        });
    }
}
