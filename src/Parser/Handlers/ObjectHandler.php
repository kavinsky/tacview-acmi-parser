<?php

namespace Kavinsky\TacviewAcmiParser\Parser\Handlers;

use Illuminate\Support\Str;
use Kavinsky\TacviewAcmiParser\Acmi;
use Kavinsky\TacviewAcmiParser\AcmiObject;
use Kavinsky\TacviewAcmiParser\AcmiObjectRecord;
use Kavinsky\TacviewAcmiParser\Collections\AcmiPropertyBag;
use Kavinsky\TacviewAcmiParser\Enum\AcmiObjectType;

class ObjectHandler implements SentenceHandlerInterface
{
    protected ?array $matches = null;

    /**
     * @inheritDoc
     */
    public function matches(string $sentence): bool
    {
        return preg_match('/([0-9a-fA-F]{0,16})\,T=(.*)/is', $sentence, $this->matches) > 0;
    }

    /**
     * @inheritDoc
     */
    public function handle(string $sentence, Acmi $acmi, float $delta = 0): void
    {
        if ($this->matches === null) {
            return;
        }

        [, $hexId, $payload] = $this->matches;

        $object = $this->getOrCreateObject($acmi, $hexId);

        $payload = explode(',', $payload);
        $transformationVector = array_shift($payload);

        $this->parseTransformation($acmi, $object, $transformationVector, $payload);

        $acmi->objects->put($hexId, $object);
    }

    /**
     * Parses the rest of the sentence getting the payload properties
     *
     * @param  array<string>  $payload
     * @return array<string,mixed>
     */
    protected function parseProperties(array $payload): array
    {
        $bag = [];
        foreach ($payload as $item) {
            [$key, $value] = explode('=', $item);
            $bag[$key] = $value;
        }

        return $bag;
    }

    /**
     * Parses the first part of the sentence, transformation vector and payload
     *
     * @param  AcmiObject  $object
     * @param  string  $transformString
     * @param  array<string>  $payload
     */
    protected function parseTransformation(Acmi $acmi, AcmiObject $object, string $transformString, array $payload = []): void
    {
        $rawTransform = explode('|', $transformString);
        match (count($rawTransform)) {
            3 => [$lon, $lat, $alt] = $rawTransform,
            5 => [$lon, $lat, $alt, $u, $v] = $rawTransform,
            6 => [$lon, $lat, $alt, $roll, $pitch, $yaw] = $rawTransform,
            9 => [$lon, $lat, $alt, $roll, $pitch, $yaw, $u, $v, $heading] = $rawTransform
        };

        $properties = $this->parseProperties($payload);
        $propertyBag = new AcmiPropertyBag($properties);

        $this->parseObjectTypeProperty($object, $properties);
        $this->parseObjectProperties($object, $properties);

        $acmi->log->push(new AcmiObjectRecord(
            objectId: $object->id,
            lon: $lon ? (float) $lon : null,
            lat: $lat ? (float) $lat : null,
            alt: $alt ? (float) $alt : null,
            roll: isset($roll) ? (float) $roll : null,
            pitch: isset($pitch) ? (float) $pitch : null,
            yaw: isset($yaw) ? (float) $yaw : null,
            u: isset($u) ? (float) $u : null,
            v: isset($v) ? (float) $v : null,
            heading: isset($heading) ? (float) $heading : null,
            propertyBag: $propertyBag
        ));
    }

    /**
     * Access to the object collection and if it exists returns it, if not creates it
     *
     * @param  Acmi  $acmi
     * @param  string  $id
     * @return AcmiObject
     */
    protected function getOrCreateObject(Acmi $acmi, string $id): AcmiObject
    {
        if ($acmi->objects->has($id)) {
            return $acmi->objects[$id];
        }

        return new AcmiObject($id);
    }

    /**
     * Parses the property Type for objects
     *
     * @param  AcmiObject  $object
     * @param  array  $properties
     */
    protected function parseObjectTypeProperty(AcmiObject $object, array $properties): void
    {
        if (array_key_exists('Type', $properties)) {
            $object->types->push(...AcmiObjectType::fromString($properties['Type']));
        }
    }

    /**
     * Parses the rest of the object properties
     *
     * @param  AcmiObject  $object
     * @param  array  $properties
     */
    protected function parseObjectProperties(AcmiObject $object, array $properties): void
    {
        $familyProperties = ['Name', 'Parent', 'Next'];

        foreach ($familyProperties as $expectKey) {
            $camelCaseKey = Str::camel($expectKey);

            if (array_key_exists($expectKey, $properties)) {
                $object->{$camelCaseKey} = $properties[$expectKey];
            }
        }
    }
}
