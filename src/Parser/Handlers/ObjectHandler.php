<?php

namespace Kavinsky\TacviewAcmiParser\Parser\Handlers;

use Kavinsky\TacviewAcmiParser\Acmi;
use Kavinsky\TacviewAcmiParser\AcmiLogRecord;
use Kavinsky\TacviewAcmiParser\AcmiObject;
use Kavinsky\TacviewAcmiParser\AcmiPropertyBag;

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

        $this->parseTransformation($object, $transformationVector, $payload);

        $acmi->objects[$hexId] = $object;
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
    protected function parseTransformation(AcmiObject $object, string $transformString, array $payload = []): void
    {
        $rawTransform = explode('|', $transformString);
        match (count($rawTransform)) {
            3 => [$lon, $lat, $alt] = $rawTransform,
            5 => [$lon, $lat, $alt, $u, $v] = $rawTransform,
            6 => [$lon, $lat, $alt, $roll, $pitch, $yaw] = $rawTransform,
            9 => [$lon, $lat, $alt, $roll, $pitch, $yaw, $u, $v, $heading] = $rawTransform
        };

        $propertyBag = new AcmiPropertyBag($this->parseProperties($payload));

        $object->properties->merge($propertyBag);

        $object->log->push(new AcmiLogRecord(
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

        return new AcmiObject();
    }
}
