<?php

namespace Kavinsky\TacviewAcmiParser\Collections;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Kavinsky\TacviewAcmiParser\Enum\AcmiObjectType;

/**
 * @template TKey as array-key
 * @template TValue AcmiObjectType
 */
class AcmiObjectTypeBag extends Collection implements Arrayable
{
    /**
     * @param  AcmiObjectType|AcmiObjectType[]  $types
     * @return bool
     */
    public function is(AcmiObjectType|array $types): bool
    {
        /** @var AcmiObjectType[] $type */
        $types = Arr::wrap($types);

        foreach ($this->items as $item) {
            foreach ($types as $type) {
                if ($item->getValue() === $type->getValue()) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->map(function (AcmiObjectType $type) {
            return $type->getValue();
        })->toArray();
    }
}
