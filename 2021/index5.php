<?php

$input = file_get_contents('input.txt');
$lines = explode("\n", $input);

$diagram = [];
$coveredLines = 0;
$maxX = 0;
$maxY = 0;

foreach ($lines as $line) {
    $coordinates = explode(' -> ', $line);
    $xy1 = explode(',', $coordinates[0]);
    $xy2 = explode(',', $coordinates[1]);

    $xloop = max($xy1[0], $xy2[0]) - min($xy1[0], $xy2[0]);
    $yloop = max($xy1[1], $xy2[1]) - min($xy1[1], $xy2[1]);
    $newPoints = [];
    for ($i = 0; $i <= max($xloop, $yloop); $i++) {
        if ($xy1[0] === $xy2[0]) {
            $x = (int) $xy1[0];
        } else if ((int) $xy1[0] < (int) $xy2[0]) {
            $x = (int) $xy1[0] + $i;
        } else if ((int) $xy1[0] > (int) $xy2[0]) {
            $x = (int) $xy1[0] - $i;
        }

        if ($xy1[1] === $xy2[1]) {
            $y = (int) $xy1[1];
        } else if ((int) $xy1[1] < (int) $xy2[1]) {
            $y = (int) $xy1[1] + $i;
        } else if ((int) $xy1[1] > (int) $xy2[1]) {
            $y = (int) $xy1[1] - $i;
        }
        if ($x > $maxX) {
            $maxX = $x;
        }
        if ($y > $maxY) {
            $maxY = $y;
        }
        $newPoints[$i] = [$x, $y];
    }

    foreach ($newPoints as $newPoint) {
        if (!isset($diagram[$newPoint[0]])) {
            $diagram[$newPoint[0]] = [];
        }
        if (!isset($diagram[$newPoint[0]][$newPoint[1]])) {
            $diagram[$newPoint[0]][$newPoint[1]] = 0;
        }
        $diagram[$newPoint[0]][$newPoint[1]]++;
    }
}

echo $coveredLines . PHP_EOL;

