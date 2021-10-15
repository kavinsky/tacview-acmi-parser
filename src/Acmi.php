<?php

namespace Kavinsky\TacviewAcmiParser;

use Illuminate\Support\Collection;
use Kavinsky\TacviewAcmiParser\Collections\AcmiLogCollection;
use Kavinsky\TacviewAcmiParser\Collections\AcmiObjectCollection;

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
     * @var AcmiLogCollection
     */
    public AcmiLogCollection $log;

    public function __construct()
    {
        $this->properties = new AcmiGlobalProperties();
        $this->objects = new AcmiObjectCollection();
        $this->log = new AcmiLogCollection();
    }
}
