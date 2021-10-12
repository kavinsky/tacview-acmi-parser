<?php

namespace Kavinsky\TacviewAcmiReader\Parser\SentenceHandlers;

use Kavinsky\TacviewAcmiReader\Acmi;
use Kavinsky\TacviewAcmiReader\AcmiObject;

class ObjectHandler implements SentenceHandlerInterface
{
    protected ?array $matches = null;

    /**
     * @inheritDoc
     */
    public function matches(string $sentence): bool
    {
        return preg_match('/([0-9a-fA-F]{0,16})\,T=(.*)/is', $sentence, $this->matches);
    }

    /**
     * @inheritDoc
     */
    public function handle(string $sentence, Acmi $acmi, float $delta = 0): void
    {
        [$sentence, $hexId, $payload] = $this->matches;

        $object = $this->getOrCreateObject($acmi, $hexId);

        $payload = explode(',', $payload);
        $transformationVector = array_shift($payload);

        $this->parseTransformation($object, $transformationVector);

        $acmi->objects[$hexId] = $object;
    }

    protected function parseProperties(AcmiObject $object, string $payload): void
    {
    }

    protected function parseTransformation(AcmiObject $object, string $transformString): void
    {
        $rawTransform = explode('|', $transformString);
        $transformVector = match (count($rawTransform)) {
            3 => [$lon, $lat, $alt] = $rawTransform,
            5 => [$lon, $lat, $alt, $u, $w] = $rawTransform,
            6 => [$lon, $lat, $alt, $roll, $pitch, $yaw] = $rawTransform,
            9 => [$lon, $lat, $alt, $roll, $pitch, $yaw, $u, $v, $heading] = $rawTransform
        };

        $object->transformationLog->push($transformVector);
    }

    protected function getOrCreateObject(Acmi $acmi, string $id): AcmiObject
    {
        if ($acmi->objects->has($id)) {
            return $acmi->objects[$id];
        }

        return new AcmiObject();
    }
}
