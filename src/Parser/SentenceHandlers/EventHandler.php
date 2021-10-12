<?php

namespace Kavinsky\TacviewAcmiReader\Parser\SentenceHandlers;

use Kavinsky\TacviewAcmiReader\Acmi;
use Kavinsky\TacviewAcmiReader\AcmiEvent;

class EventHandler implements SentenceHandlerInterface
{
    protected ?array $matches = null;

    /**
     * @inheritDoc
     */
    public function matches(string $sentence): bool
    {
        return preg_match('/^0\,Event\=(\w*)\|(.*)/is', $sentence, $this->matches);
    }

    /**
     * @inheritDoc
     */
    public function handle(string $sentence, Acmi $acmi, float $delta = 0): void
    {
        [$sentence, $eventName, $payload] = $this->matches;
        $eventTime = $acmi->getPlusDelta($delta);

        $acmi->events->add(new AcmiEvent(
            $eventTime,
            $eventName,
            $this->parsePayload($payload)
        ));
    }

    /**
     * Parses the payload
     *
     * @todo revisit this when the rest of the lib is done, (so never).
     *
     * @param  string  $payload
     * @return array
     */
    protected function parsePayload(string $payload): array
    {
        return collect(explode('|', $payload))
            ->map(fn ($item) => explode(':', $item))
            ->toArray();
    }
}
