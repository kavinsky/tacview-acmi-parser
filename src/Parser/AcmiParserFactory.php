<?php

namespace Kavinsky\TacviewAcmiReader\Parser;

use Kavinsky\TacviewAcmiReader\Acmi;
use Kavinsky\TacviewAcmiReader\Parser\Reader\AcmiReaderInterface;
use Kavinsky\TacviewAcmiReader\Parser\Reader\AcmiTextReader;
use Kavinsky\TacviewAcmiReader\Parser\Reader\AcmiZipReader;
use Kavinsky\TacviewAcmiReader\Parser\SentenceHandlers\EventHandler;
use Kavinsky\TacviewAcmiReader\Parser\SentenceHandlers\FileHeadersHandler;
use Kavinsky\TacviewAcmiReader\Parser\SentenceHandlers\GlobalPropertyHandler;
use Kavinsky\TacviewAcmiReader\Parser\SentenceHandlers\ObjectHandler;
use Kavinsky\TacviewAcmiReader\Parser\SentenceHandlers\SentenceHandlerInterface;

class AcmiParserFactory
{
    /**
     * @var array<AcmiReaderInterface>
     */
    protected array $readers = [];

    /**
     * @var array<SentenceHandlerInterface>
     */
    protected ?array $handlers = null;

    public function __construct(AcmiReaderInterface|array $readers = [], SentenceHandlerInterface|array $handlers = [])
    {
        if (is_array($readers) && count($readers) < 1) {
            $readers = static::defaultReaders();
        }

        $this->setReader($readers);

        if (is_array($handlers) && count($handlers) < 1) {
            $handlers = static::defaultHandlers();
        }

        $this->setHandlers($handlers);
    }


    /**
     * @param string $filePath
     * @return Acmi
     * @throws \Exception
     */
    public function parse(string $filePath): Acmi
    {
        $reader = $this->getSupportedReader($filePath);

        return (new AcmiParser($reader, $this->handlers))
            ->parseFromFile($filePath);
    }

    /**
     * This are the default readers to work with.
     *
     * @return array
     */
    public static function defaultReaders(): array
    {
        return [
            new AcmiZipReader(),
            new AcmiTextReader(),
        ];
    }



    /**
     * This are the default handlers to work with.
     *
     * @return FileHeadersHandler[]
     */
    public static function defaultHandlers(): array
    {
        return [
            new ObjectHandler(),
            new EventHandler(),
            new GlobalPropertyHandler(),
            new FileHeadersHandler(),
        ];
    }

    /**
     * Overrides the current registered readers
     *
     * @param AcmiReaderInterface|array<AcmiReaderInterface> $readers
     * @return $this
     */
    public function setReader(AcmiReaderInterface|array $readers): self
    {
        if (! is_array($readers)) {
            $readers = [$readers];
        }

        $this->readers = $readers;

        return $this;
    }

    /**
     * Appends a sentence handler to the registry
     *
     * @param SentenceHandlerInterface $handler
     * @return $this
     */
    public function addHandler(SentenceHandlerInterface $handler): self
    {
        array_push($this->handlers, $handler);

        return $this;
    }

    /**
     * Sets the Handler library
     *
     * @param SentenceHandlerInterface|array<SentenceHandlerInterface> $handlers
     * @return $this
     */
    public function setHandlers(SentenceHandlerInterface|array $handlers): self
    {
        if (! is_array($handlers)) {
            $handlers = [$handlers];
        }

        $this->handlers = $handlers;

        return $this;
    }

    /**
     * Gets a supported by the filePath acmi reader.
     *
     * @param string $filePath
     * @return AcmiReaderInterface
     * @throws \Exception
     */
    protected function getSupportedReader(string $filePath): AcmiReaderInterface
    {
        foreach ($this->readers as $reader) {
            if ($reader->supports($filePath)) {
                return $reader;
            }
        }

        throw new \Exception('No supported readers available to read file: '.basename($filePath));
    }
}
