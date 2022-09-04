<?php

declare (strict_types = 1);

require 'gentree.php';

$json = fopen($pathTo, 'r');

$pathCompare = $base . 'output_correct.json';
$jsonCompare = fopen($pathCompare, 'r');

$counter = 0;
while ($line = fgets($json)) {
    $counter++;

    $line = trim($line);
    
    $lineCompare = fgets($jsonCompare);
    $lineCompare = trim($lineCompare);

    if ($line === $lineCompare) continue;
    echo "
    Строка $counter:
    получено: $line,
    сравнить: $lineCompare
    
    ";
    die();
}

echo "
Результат полностью верный 

";
