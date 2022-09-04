<?php

declare (strict_types = 1);

namespace App\Writers;

interface WriterContract
{
    public function __construct(string $filePath);
    public function write(array $array);
}
