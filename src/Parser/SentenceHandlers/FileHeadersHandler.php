<?php

namespace Kavinsky\TacviewAcmiParser\Parser\SentenceHandlers;

use Kavinsky\TacviewAcmiParser\Acmi;

class FileHeadersHandler implements SentenceHandlerInterface
{
    /**
     * {@inheritDoc}
     */
    public function matches(string $sentence): bool
    {
        return str_starts_with($sentence, 'FileType=') || str_starts_with($sentence, 'FileVersion=');
    }

    /**
     * {@inheritDoc}
     */
    public function handle(string $sentence, Acmi $acmi, float $delta = 0): void
    {
        if (str_starts_with($sentence, 'FileType=')) {
            // noop
        }

        if (str_starts_with($sentence, 'FileVersion=')) {
            $acmi->version = str_replace('FileVersion=', '', $sentence);
        }
    }
}
