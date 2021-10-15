<?php

namespace Kavinsky\TacviewAcmiParser\Enum;

use MabeEnum\Enum;

/**
 * @psalm-immutable
 */
final class AcmiDateFormat extends Enum
{
    public const NORMAL = 'Y-m-d\TH:i:s\Z';
    public const EXTENDED = 'Y-m-d\TH:i:s.u\Z';

    /**
     *
     * @codeCoverageIgnore
     * @return array<string>
     */
    public static function all(): array
    {
        return [
            AcmiDateFormat::NORMAL,
            AcmiDateFormat::EXTENDED,
        ];
    }
}
