<?php

namespace Kavinsky\TacviewAcmiReader\Reader;

use Kavinsky\TacviewAcmiReader\Reader\Exceptions\AccessErrorException;
use ZipArchive;

class AcmiZipReader extends AbstractFileReader
{
    protected ZipArchive $zipArchive;

    public function supports(string $filePath): bool
    {
        return str_ends_with($filePath, '.zip.acmi');
    }

    public function start(string $filePath): void
    {
        if (! in_array('zip', stream_get_wrappers())) {
            throw new \Exception('Zip isn\'t supported by your current PHP, is not between stream_get_wrappers().');
        }

        $this->zipArchive = new ZipArchive();

        if (! $archive = $this->zipArchive->open($filePath)) {
            throw new \Exception($this->zipArchive->getStatusString());
        }

        try {
            $fileName = $this->zipArchive->getNameIndex(0);
            $this->handle = $this->zipArchive->getStream($fileName);
        } catch (\Error $e) {
            throw new AccessErrorException($e->getMessage());
        }
    }
}
