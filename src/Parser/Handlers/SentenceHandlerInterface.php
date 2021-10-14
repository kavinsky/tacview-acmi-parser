<?php

namespace Kavinsky\TacviewAcmiParser\Parser\Handlers;

use Kavinsky\TacviewAcmiParser\Acmi;

interface SentenceHandlerInterface
{
    /**
     * Checks if the passed sentence is compatible with this handler.
     *
     * @param  string  $sentence
     * @return bool
     */
    public function matches(string $sentence): bool;

    /**
     * Handles the sentence on the given Acmi class.
     *
     * @param  string  $sentence
     * @param  Acmi  $acmi
     */
    public function handle(string $sentence, Acmi $acmi, float $delta = 0): void;
}
