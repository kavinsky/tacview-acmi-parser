<?php

namespace Kavinsky\TacviewAcmiParser\Collections;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Kavinsky\TacviewAcmiParser\Enum\AcmiObjectType;

class AcmiObjectTypeBag extends Collection
{
    /**
     * The items contained in the collection.
     *
     * @var array<AcmiObjectType>
     */
    protected $items = [];

    /**
     * @param  AcmiObjectType|array<AcmiObjectType>  $type
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
}
