<?php

namespace Kavinsky\TacviewAcmiParser;

use Carbon\CarbonImmutable;
use Illuminate\Contracts\Support\Arrayable;

abstract class AcmiRecord implements Arrayable
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

    /**
     *
     * @psalm-mutation-free
     * @return array
     */
    protected function toRecordArray(array $properties = []): array
    {
        return [
            'recordType' => self::class,
            'properties' => $properties,
        ];
    }
}
