<?php

namespace Kavinsky\TacviewAcmiParser\Enum;

final class AcmiDateFormat
{
    public const NORMAL = 'Y-m-d\TH:i:s\Z';
    public const EXTENDED = 'Y-m-d\TH:i:s.u\Z';

    /**
     * @return array<string>
     */
    public static function all(): array
    {
        return [
            static::NORMAL,
            static::EXTENDED,
        ];
    }
}
