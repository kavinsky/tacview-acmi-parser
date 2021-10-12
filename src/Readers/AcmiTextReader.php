<?php

namespace Kavinsky\TacviewAcmiReader\Readers;

class AcmiTextReader extends AbstractFileReader
{
    public function supports(string $filePath): bool
    {
        return str_ends_with($filePath, '.text.acmi');
    }

    public function start(string $filePath): void
    {
        $this->handle = $this->makeHandle('file://'.$filePath);
    }
}
