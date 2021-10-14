<?php

namespace Kavinsky\TacviewAcmiParser;

use Illuminate\Support\Collection;

/**
 * The ACMI Report Object
 *
 * @see https://www.tacview.net/documentation/acmi/en/
 */
class Acmi
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
     * @var Collection
     */
    public Collection $objects;

    /**
     * @var Collection
     */
    public Collection $events;

    public function __construct()
    {
        $this->properties = new AcmiGlobalProperties();
        $this->events = collect();
        $this->objects = collect();
    }
}
