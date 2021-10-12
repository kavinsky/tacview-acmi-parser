<?php

namespace Kavinsky\TacviewAcmiReader\Parser\SentenceHandlers;

use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Support\Str;
use Kavinsky\TacviewAcmiReader\Acmi;

class GlobalPropertyHandler implements SentenceHandlerInterface
{
    protected ?array $matches = null;

    /**
     * @inheritDoc
     */
    public function matches(string $sentence): bool
    {
        return preg_match('/^0\,(\w*)\=(.*)/is', $sentence, $this->matches);
    }

    /**
     * @inheritDoc
     */
    public function handle(string $sentence, Acmi $acmi, float $delta = 0): void
    {
        if ($this->matches === null) {
            return;
        }

        [$sentence, $propertyKey, $value] = $this->matches;
        $propertyKey = Str::camel($propertyKey);

        try {
            $acmiReflectionClass = new \ReflectionClass($acmi);
            $acmiProperty = $acmiReflectionClass->getProperty($propertyKey);

            if ($this->isPropertyTypeScalar($acmiProperty->getType())) {
                $value = match ($acmiProperty->getType()->getName()) {
                    default => stripcslashes((string) $value),
                    'float' => (float) $value,
                    'int' => (int) $value,
                };

                $acmi->{$propertyKey} = $value;

                return;
            }

            if ($this->isPropertyTypeDateTimeInterface($acmiProperty->getType())) {
                $acmi->{$propertyKey} = $this->makeDate($value);
            }
        } catch (\ReflectionException $e) {
        }
    }

    /**
     * Checks if a propertyType is a Scalar Value
     *
     * @param  \ReflectionUnionType|\ReflectionNamedType|null  $type
     * @return bool
     */
    protected function isPropertyTypeScalar(\ReflectionUnionType|\ReflectionNamedType|null $type): bool
    {
        return in_array($type?->getName(), ['string', 'int', 'float']);
    }

    /**
     * Checks if a propertyType is a DateTimeInterface
     *
     * @param  \ReflectionUnionType|\ReflectionNamedType|null  $type
     * @return bool
     */
    private function isPropertyTypeDateTimeInterface(\ReflectionUnionType|\ReflectionNamedType|null $type): bool
    {
        return in_array($type?->getName(), [\DateTimeInterface::class, Carbon::class]);
    }

    /**
     * Creates a Carbon Date parsing from posible formats
     *
     * @param  string  $value
     * @return Carbon|null
     */
    private function makeDate(string $value): ?Carbon
    {
        $formats = [
            'Y-m-d\TH:i:s.u\Z',
            'Y-m-d\TH:i:s\Z',
        ];

        foreach ($formats as $format) {
            try {
                $date = Carbon::createFromFormat(
                    $format,
                    $value,
                    new \DateTimeZone('UTC')
                );

                if ($date) {
                    return $date;
                }
            } catch (InvalidFormatException $e) {
                // no op
            }
        }

        return null;
    }
}
