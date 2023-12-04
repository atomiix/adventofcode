<?php

$input = file_get_contents('input.txt');
$positions = array_map(fn ($item) => (int) $item, explode(",", $input));

$max = $positions[0];
$min = $positions[0];
$bestPosition = [];

foreach ($positions as $position) {
    if ($position > $max) {
        $max = $position;
    }
    if ($position < $min) {
        $min = $position;
    }
}

foreach ($positions as $position) {
    for ($i = $min; $i <= $max; $i++) {
        if (!isset($bestPosition[$i])) {
            $bestPosition[$i] = 0;
        }
        $fuel = abs($position-$i);
        $bestPosition[$i] += $fuel * ($fuel + 1) / 2;
    }
}
asort($bestPosition);
echo current($bestPosition) . PHP_EOL;