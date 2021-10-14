<?php

namespace Kavinsky\TacviewAcmiParser\Parser\Reader;

use Kavinsky\TacviewAcmiParser\Parser\Reader\Exceptions\AccessErrorException;
use Kavinsky\TacviewAcmiParser\Parser\Reader\Exceptions\EndOfFileException;

abstract class AbstractStreamReader implements AcmiReaderInterface
{
    /**
     * @var resource|null
     */
    protected $handle;

    /**
     * @var ?string
     */
    protected ?string $line = null;

    protected bool $feof = false;

    public function __destruct()
    {
        if (is_resource($this->handle)) {
            fclose($this->handle);
        }
    }

    /**
     * @param  string  $fileUrlHandle
     * @return resource
     * @throws AccessErrorException
     */
    protected function makeHandle(string $fileUrlHandle)
    {
        try {
            $handle = fopen($fileUrlHandle, 'r');

            if ($handle === false) {
                throw new AccessErrorException();
            }

            return $handle;
        } catch (\ErrorException $e) {
            throw new AccessErrorException();
        }
    }

    /**
     * Returns the next line in the pointer
     *
     * @param  int  $length
     * @return string
     * @throws EndOfFileException|AccessErrorException
     */
    public function nextLine(int $length = 4096): ?string
    {
        if (! $this->eof()) {
            $line = fgets($this->handle, $length);

            if (! $line) {
                $this->feof = true;

                return null;
            }

            if (! $this->line) {
                $bom = pack('CCC', 0xEF, 0xBB, 0xBF);
                $line = str_replace($bom, '', $line);
            }


            $this->line = $line;

            return $this->line;
        }

        return null;
    }

    /**
     * Returns the current line in the pointer
     *
     * @return ?string
     */
    public function line(): ?string
    {
        return $this->line;
    }

    /**
     * Gets and moves the pointer to the next sentence
     *
     * @param  int  $length
     * @return string
     */
    public function nextSentence(int $length = 4096): ?string
    {
        if ($this->eof()) {
            return null;
        }

        $sentence = '';

        do {
            $sentence .= $this->nextLine($length) ?? '';
        } while (! $this->eof() && $this->isSentenceIncomplete());

        return trim($sentence);
    }

    /**
     * Checks if the sentence is finished, used with "\" at end of line
     *
     * @return bool
     */
    public function isSentenceIncomplete(): bool
    {
        return substr($this->line() ?? '', -2, 2) === AcmiReaderInterface::LINE_SPLIT_CHAR;
    }

    /**
     * Checks if the reader is at end of file
     *
     * @return bool
     */
    public function eof(): bool
    {
        return $this->feof || feof($this->handle);
    }
}
