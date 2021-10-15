<?php

namespace Kavinsky\TacviewAcmiParser;

use Carbon\CarbonImmutable;

abstract class AcmiRecord
{
    /**
     * @var CarbonImmutable
     */
    private CarbonImmutable $timestamp;

    /**
     * @param  CarbonImmutable  $timestamp
     */
    public function setTimeframe(CarbonImmutable $timestamp): void
    {
        $this->timestamp = $timestamp;
    }

    /**
     * Returns when the Record happens
     *
     * @return CarbonImmutable
     */
    public function timestamp(): CarbonImmutable
    {
        return $this->timestamp;
    }
}
