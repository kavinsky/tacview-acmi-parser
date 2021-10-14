<?php

namespace Kavinsky\TacviewAcmiReader;

use Illuminate\Support\Collection;

class AcmiPropertyBag
{
    protected Collection $bag;

    public function __construct(array $properties = [])
    {
        $this->bag = new Collection($properties);
    }

    public function set(string $propertyKey, string $value): self
    {
        $this->bag->put($propertyKey, $value);

        return $this;
    }

    /**
     *
     */
    public function has(string $propertyKey): bool
    {
        return $this->bag->has($propertyKey);
    }

    /**
     * Gets a property of the bag
     */
    public function get(string $propertyKey, mixed $default): mixed
    {
        return $this->bag->get($propertyKey, $default);
    }

    public function merge(self $otherBag): self
    {
        $this->bag = $this->bag->merge($otherBag);

        return $this;
    }
}
