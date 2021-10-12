<?php

namespace Kavinsky\TacviewAcmiReader\Parser;

use Kavinsky\TacviewAcmiReader\Acmi;
use Kavinsky\TacviewAcmiReader\Parser\SentenceHandlers\EventHandler;
use Kavinsky\TacviewAcmiReader\Parser\SentenceHandlers\FileHeadersHandler;
use Kavinsky\TacviewAcmiReader\Parser\SentenceHandlers\GlobalPropertyHandler;
use Kavinsky\TacviewAcmiReader\Parser\SentenceHandlers\ObjectHandler;
use Kavinsky\TacviewAcmiReader\Parser\SentenceHandlers\SentenceHandlerInterface;
use Kavinsky\TacviewAcmiReader\Readers\AcmiReaderInterface;

class AcmiParser
{
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
        $this->handlers = count($handlers) > 0 ? $handlers : $this->getDefaultHandlers();
    }

    /**
     * This are the default handlers to work with.
     *
     * @return FileHeadersHandler[]
     */
    protected function getDefaultHandlers(): array
    {
        return [
            new ObjectHandler(),
            new EventHandler(),
            new GlobalPropertyHandler(),
            new FileHeadersHandler(),
        ];
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
        $sentenceCount = 0;
        while (! $this->reader->eof()) {
            $sentence = $this->reader->nextSentence();

            if ($sentence === null) {
                break;
            }

            if (str_starts_with($sentence, '#')) {
                $delta = (float) substr($sentence, 1, strlen($sentence));

                continue;
            }

            foreach ($this->handlers as $handler) {
                if ($handler->matches($sentence)) {
                    $handler->handle($sentence, $this->acmi, $delta);
                }
            }

            $sentenceCount++;
        }

        return $this->acmi;
    }
}
