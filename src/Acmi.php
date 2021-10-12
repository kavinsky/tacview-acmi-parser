<?php

namespace Kavinsky\TacviewAcmiReader;

use Carbon\Carbon;
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
     * Base time (UTC) for the current mission. (In Game)
     *
     * This time is combined with each frame offset (in seconds) to get the final
     * absolute UTC time for each data sample.
     *
     * @var Carbon|null
     */
    public ?Carbon $referenceTime = null;

    /**
     * Recording (file) creation (UTC) time. (Real Time)
     *
     * @var Carbon|null
     */
    public ?Carbon $recordingTime = null;

    /**
     * Mission/flight title or designation.
     *
     * @var string|null
     */
    public ?string $title = null;

    /**
     * Software or hardware used to record the data.
     *
     * @var string|null
     */
    public ?string $dataRecorder = null;

    /**
     * Author or operator who has created this recording.
     *
     * @var string|null
     */
    public ?string $author = null;

    /**
     * These properties are used to reduce the file size by centering coordinates around a median point.
     * They will be added to each object Longitude and Latitude to get the final coordinates.
     *
     * Unit: deg
     *
     * @var float|null
     */
    public ?float $referenceLongitude = null;

    /**
     * These properties are used to reduce the file size by centering coordinates around a median point.
     * They will be added to each object Longitude and Latitude to get the final coordinates.
     *
     * Unit: deg
     *
     * @var float|null
     */
    public ?float $referenceLatitude = null;

    /**
     * Category of the flight/mission.
     *
     * @var string|null
     */
    public ?string $category = null;

    /**
     * Free text containing the briefing of the flight/mission.
     *
     * @var string|null
     */
    public ?string $briefing = null;

    /**
     * Free text containing the debriefing.
     *
     * @var string|null
     */
    public ?string $debriefing = null;


    /**
     * Free comments about the flight.
     *
     * @var string|null
     */
    public ?string $comments = null;

    /**
     * @var Collection<AcmiEvent>
     */
    public Collection $events;

    /**
     * @var Collection<AcmiObject>
     */
    public Collection $objects;

    public function __construct()
    {
        $this->events = collect();
        $this->objects = collect();
    }

    /**
     * A helper method to return a DateTimeInterface with added delta from referenceTime.
     *
     * @param  float|int  $delta
     * @return Carbon
     */
    public function getPlusDelta(float|int $delta = 0): Carbon
    {
        return $this->referenceTime->clone()->addMicroseconds(
            $delta * 1000
        );
    }
}
