<?php

namespace Kavinsky\TacviewAcmiParser;

use Illuminate\Contracts\Support\Arrayable;
use Kavinsky\TacviewAcmiParser\Collections\AcmiObjectTypeBag;

class AcmiObject implements Arrayable
{
    /**
     * Object ids are expressed using 64-bit hexadecimal numbers (without prefix or leading zeros to save space).
     *
     * @var string
     */
    public string $id;

    /**
     * The object name should use the most common notation for each object.
     * It is strongly recommended to use ICAO or NATO names like: C172 or F/A-18C. This will help Tacview
     * to associate each object with the corresponding entry in its database. Type and Name are the
     * only properties which *CANNOT* be predefined in Tacview database.
     *
     * @var string
     */
    public ?string $name = null;

    /**
     * Parent hexadecimal object id. Useful to associate for example a missile
     * (child object) and its launcher aircraft (parent object).
     *
     * @var string
     */
    public ?string $parent = null;

    /**
     * Hexadecimal id of the following object. Typically, used to link waypoints together.
     *
     * @var string
     */
    public ?string $next = null;

    /**
     * @see https://www.tacview.net/documentation/acmi/en/#:~:text=Object%20Types%20(aka%20Tags)
     * @var AcmiObjectTypeBag
     */
    public AcmiObjectTypeBag $types;

    public function __construct(string $id)
    {
        $this->id = $id;
        $this->types = new AcmiObjectTypeBag();
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'parent' => $this->parent,
            'next' => $this->next,
            'types' => $this->types->toArray(),
        ];
    }
}
