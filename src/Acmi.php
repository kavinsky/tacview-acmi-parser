<?php

namespace Kavinsky\TacviewAcmiParser;

use Illuminate\Contracts\Support\Arrayable;
use Kavinsky\TacviewAcmiParser\Collections\AcmiLogCollection;
use Kavinsky\TacviewAcmiParser\Collections\AcmiObjectCollection;

/**
 * The ACMI Report Object
 *
 * @see https://www.tacview.net/documentation/acmi/en/
 *
 */
class Acmi implements Arrayable
{
    /**
     * Version of the TacView ACMI file format
     *
     * @var string|null
     */
    public ?string $version = null;

    /**
     * ACMI Global Properties
     *
     * @var AcmiGlobalProperties
     */
    public AcmiGlobalProperties $properties;

    /**
     * @var AcmiObjectCollection
     */
    public AcmiObjectCollection $objects;

    /**
     * @var AcmiLogCollection
     */
    public AcmiLogCollection $log;

    public function __construct()
    {
        $this->properties = new AcmiGlobalProperties();
        $this->objects = new AcmiObjectCollection();
        $this->log = new AcmiLogCollection();
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'version' => $this->version,
            'properties' => $this->properties->toArray(),
            'objects' => $this->toArray(),
            'log' => $this->log->toArray(),
        ];
    }
}
