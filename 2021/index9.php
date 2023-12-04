<?php

$input = file_get_contents('input.txt');
$lines = explode("\n", $input);

$lowest = [];
$basins = [];

foreach ($lines as $i => $line) {
    foreach (str_split($line) as $j => $digit) {
        if ($j-1 >= 0 && (int) $line[$j-1] <= (int) $digit) {
            continue;
        }
        if (isset($line[$j+1]) && (int) $line[$j+1] <= (int) $digit) {
            continue;
        }
        if (isset($lines[$i-1][$j]) && (int) $lines[$i-1][$j] <= (int) $digit) {
            continue;
        }
        if (isset($lines[$i+1][$j]) && (int) $lines[$i+1][$j] <= (int) $digit) {
            continue;
        }
        $lowest["$j,$i"] = (int) $digit;
    }
}

foreach ($lowest as $coord => $low) {
    $xy = explode(',', $coord);
    $points = [];
    find($xy[0], $xy[1], $lines, $points);
    $basins[$coord] = $points;
}

function find(int $x, int $y, array $lines, array &$points) {
    $value = (int) $lines[$y][$x];
    if (isset($points["$x,$y"])) {
        return;
    }
    $points["$x,$y"] = $value;

    if ($x-1 >= 0 && (int) $lines[$y][$x-1] < 9) {
        find($x-1, $y, $lines, $points);
    }
    if (isset($lines[$y][$x+1]) && (int) $lines[$y][$x+1] < 9) {
        find($x+1, $y, $lines, $points);
    }
    if ($y-1 >= 0 && (int) $lines[$y-1][$x] < 9) {
        find($x, $y-1, $lines, $points);
    }
    if (isset($lines[$y+1][$x]) && (int) $lines[$y+1][$x] < 9) {
        find($x, $y+1, $lines, $points);
    }
}

$bassinsCount = [];
foreach ($basins as $basin) {
    $bassinsCount[] = count($basin);
}
rsort($bassinsCount);

echo array_product(array_slice($bassinsCount, 0, 3)) . PHP_EOL;