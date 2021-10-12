<?php

namespace Kavinsky\TacviewAcmiReader\Readers;

class AcmiZipReader extends AbstractFileReader
{
    public function supports(string $filePath): bool
    {
        return str_ends_with($filePath, '.zip.acmi');
    }

    public function start(string $filePath): void
    {
        $this->handle = $this->makeHandle('zip://'.$filePath);
    }
}
