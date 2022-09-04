<?php

declare (strict_types = 1);

namespace App\Writers;

class JSONWriter implements WriterContract
{
    private $destFile;

    public function __construct(string $filePath)
    {
        $this->destFile = fopen($filePath, 'w');
    }

    public function write(array $array)
    {
        fwrite($this->destFile, json_encode($array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
