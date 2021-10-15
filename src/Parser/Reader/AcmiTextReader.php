<?php

namespace Kavinsky\TacviewAcmiParser\Parser\Reader;

class AcmiTextReader extends AbstractStreamReader
{
    public function supports(string $filePath): bool
    {
        return str_ends_with($filePath, '.txt.acmi');
    }

    public function start(string $filePath): void
    {
        $this->handle = $this->makeHandle('file://'.$filePath);
    }
}
