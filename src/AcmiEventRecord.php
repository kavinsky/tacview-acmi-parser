<?php

namespace Kavinsky\TacviewAcmiParser;

class AcmiEventRecord extends AcmiRecord
{
    /**
     * @var string
     */
    public string $name;

    /**
     * @var array
     */
    public array $properties;

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return parent::toRecordArray([
            'name' => $this->name,
            'properties' => $this->properties,
        ]);
    }
}
