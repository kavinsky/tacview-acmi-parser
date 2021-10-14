<?php

namespace Kavinsky\TacviewAcmiReader;

use Illuminate\Support\Collection;

class AcmiPropertyBag
{
    /**
     * The BAG
     *
     * @var Collection
     */
    protected Collection $bag;

    public function __construct(array $properties = [])
    {
        $this->bag = new Collection($properties);
    }

    /**
     * Sets a property inside the bag
     *
     * @param string $propertyKey
     * @param string $value
     * @return $this
     */
    public function set(string $propertyKey, string $value): self
    {
        $this->bag->put($propertyKey, $value);

        return $this;
    }

    /**
     * Checks if a property exists inside the bag
     *
     * @param string $propertyKey
     * @return bool
     */
    public function has(string $propertyKey): bool
    {
        return $this->bag->has($propertyKey);
    }

    /**
     * Gets a property from the bag, returns $default if not exists
     *
     * @param string $propertyKey
     * @param mixed $default
     * @return mixed
     */
    public function get(string $propertyKey, mixed $default): mixed
    {
        return $this->bag->get($propertyKey, $default);
    }

    /**
     * Merges two bags
     *
     * @param AcmiPropertyBag $otherBag
     * @return $this
     */
    public function merge(self $otherBag): self
    {
        $this->bag = $this->bag->merge($otherBag);

        return $this;
    }
}
