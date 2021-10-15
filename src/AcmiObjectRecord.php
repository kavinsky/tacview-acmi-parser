<?php

namespace Kavinsky\TacviewAcmiParser;

use Kavinsky\TacviewAcmiParser\Collections\AcmiPropertyBag;

/**
 * @psalm-immutable
 */
class AcmiObjectRecord extends AcmiRecord
{
    /**
     * The ObjectId
     */
    public ?string $objectId;

    /**
     * Longitude in Degress
     */
    public ?float $longitude = null;

    /**
     * Latitude in Degress
     */
    public ?float $latitude = null;

    /**
     * Altitude in Meters
     */
    public ?float $altitude = null;

    /**
     * Roll is positive when rolling the aircraft to the right
     */
    public ?float $roll = null;

    /**
     * Pitch is positive when taking-off
     */
    public ?float $pitch = null;

    /**
     * Yaw is clockwise relative to the true north.
     */
    public ?float $yaw = null;

    /**
     * U & V represent the native x and y.
     *
     * Do not forget to express them in meters even if the original coordinates
     * are in feet for example. Altitude is not repeated because it is the same
     * for both native and spherical worlds.
     */
    public ?float $u = null;

    /**
     * U & V represent the native x and y.
     *
     * Do not forget to express them in meters even if the original coordinates
     * are in feet for example. Altitude is not repeated because it is the same
     * for both native and spherical worlds.
     */
    public ?float $v = null;

    /**
     * Heading relative to local magnetic north.
     */
    public ?float $heading = null;

    public AcmiPropertyBag $properties;

    public function __construct(
        ?string $objectId = null,
        ?float $lon = null,
        ?float $lat = null,
        ?float $alt = null,
        ?float $roll = null,
        ?float $pitch = null,
        ?float $yaw = null,
        ?float $u = null,
        ?float $v = null,
        ?float $heading = null,
        ?AcmiPropertyBag $propertyBag = null
    ) {
        $this->objectId = $objectId;
        $this->longitude = $lon;
        $this->latitude = $lat;
        $this->altitude = $alt;
        $this->roll = $roll;
        $this->pitch = $pitch;
        $this->yaw = $yaw;
        $this->u = $u;
        $this->v = $v;
        $this->heading = $heading;
        $this->properties = $propertyBag;
    }
}
