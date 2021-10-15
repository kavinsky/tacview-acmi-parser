<?php

namespace Kavinsky\TacviewAcmiParser\Parser;

use Kavinsky\TacviewAcmiParser\Acmi;
use Kavinsky\TacviewAcmiParser\Parser\Handlers\SentenceHandlerInterface;
use Kavinsky\TacviewAcmiParser\Parser\Reader\AcmiReaderInterface;

class AcmiParser
{
    /**
     * The registered Reader
     *
     * @var AcmiReaderInterface
     */
    protected AcmiReaderInterface $reader;

    /**
     * The ACMI file.
     *
     * @var Acmi
     */
    protected Acmi $acmi;

    /**
     * SentenceHandlers
     *
     * @var SentenceHandlerInterface[]
     */
    protected array $handlers;

    /**
     * @param  AcmiReaderInterface  $reader
     * @param  array  $handlers
     */
    public function __construct(AcmiReaderInterface $reader, array $handlers = [])
    {
        $this->reader = $reader;
        $this->handlers = $handlers;
    }

    /**
     * @param  string  $filePath
     * @return Acmi
     */
    public function parseFromFile(string $filePath): Acmi
    {
        $this->reader->start($filePath);

        $this->acmi = new Acmi();
        $delta = 0.0;
        while (! $this->reader->eof()) {
            $sentence = $this->reader->nextSentence();

            if ($sentence === null) {
                break;
            }

            $delta = $this->parseTimeframeChange($sentence, $delta);

            $this->runHandlers($sentence, $delta);
        }

        return $this->acmi;
    }

    /**
     * Executes the registered handlers over the given sentence
     *
     * @param string|null $sentence The sentence to process by the handlers
     * @param float $delta Delta in seconds from the mission referenceTime.
     */
    protected function runHandlers(?string $sentence, float $delta = 0): void
    {
        foreach ($this->handlers as $handler) {
            if ($handler->matches($sentence)) {
                $handler->handle($sentence, $this->acmi, $delta);
            }
        }
    }

    /**
     * Parses for the #0.0 sentence to change the timeframe
     *
     * @param  string  $sentence
     * @param  float  $delta
     * @return float
     * @throws \Exception
     */
    protected function parseTimeframeChange(string $sentence, float $delta = 0.0): float
    {
        if (str_starts_with($sentence, '#')) {
            if ($this->acmi->properties->referenceTime === null) {
                throw new \Exception('The ACMI Report is not correctly formated, no ReferenceTime set before #timestamp change.');
            }

            return (float) substr($sentence, 1, strlen($sentence));
        }

        return $delta;
    }
}
