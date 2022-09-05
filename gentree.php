<?php

declare (strict_types = 1);

use App\Readers\CSVReader;
use App\Tree\TreeBuilder;
use App\Tree\Tree;
use App\Writers\JSONWriter;

require 'vendor/autoload.php';

// $base = __DIR__ . '/data/short/';
// $base = __DIR__ . '/data/medium/';
$base = __DIR__ . '/data/full/';

$pathFrom = $base . 'input.csv';
$pathTo = $base . 'output.json';

$reader = new CSVReader($pathFrom);

TreeBuilder::setReader($reader);
TreeBuilder::buildTree();

$writer = new JSONWriter($pathTo);
$writer->write(Tree::$tree);
