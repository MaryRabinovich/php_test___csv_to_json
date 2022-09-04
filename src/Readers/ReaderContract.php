<?php

declare (strict_types = 1);

namespace App\Readers;

interface ReaderContract
{
    public function __construct(string $filePath);
    public function next(): ?array;
}
