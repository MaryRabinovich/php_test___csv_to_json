<?php

declare (strict_types = 1);

namespace App\Readers;

class CSVReader implements ReaderContract
{
    private $sourceFile;

    public function __construct(string $filePath)
    {
        $this->sourceFile = fopen($filePath, 'r');
        fgets($this->sourceFile); // выкидываем первую строчку с названиями столбцов
    }

    public function next(): ?array
    {
        $line = fgets($this->sourceFile);
        if (!$line) return null;
        $array = explode(';', $line);
        $formatted = $this->formatValues($array);
        return $this->addKeys($formatted);
    }

    private function formatValues(array $array)
    {
        return array_map(function ($string) {
            // $string = str_replace("\n", '', $string);
            $string = str_replace(PHP_EOL, '', $string);
            $string = str_replace('"', '', $string);
            return $string;
        }, $array);
    }

    private function addKeys(array $array): array
    {
        return [
            'itemName' => $array[0],
            'type' => $array[1],
            'parent' => $array[2],
            'relation' => $array[3]
        ];
    }
}
