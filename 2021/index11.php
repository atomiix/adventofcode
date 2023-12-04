<?php

$input = file_get_contents('input.txt');
$lines = explode("\n", $input);
$steps = 200;
$octopuses = [];
foreach ($lines as $i => $line) {
    $octopuses[$i] = [];
    foreach (str_split($line) as $j => $octopus) {
        $octopuses[$i][$j] = (int) $octopus;
    }
}

for ($step = 1; ; $step++) {
    $flashed = [];
    $flashes = 0;
    foreach ($octopuses as $i => $line) {
        foreach ($line as $j => $octopus) {
            $octopuses[$i][$j]++;
            if ($octopuses[$i][$j] > 9) {
                $octopuses[$i][$j] = 0;
                $flashed[] = "$i,$j";
                $flashes++;
            }
        }
    }
    $flashes += flash($flashed, $octopuses);
    if ($flashes === 100) {
        break;
    }
}

function flash($flashed, &$octopuses) {
    $newFlashed = [];
    $flashes = 0;
    foreach ($flashed as $octopus) {
        $coords = explode(',', $octopus);
        for ($i = ((int)$coords[0]) - 1; $i <= ((int)$coords[0]) + 1; $i++) {
            for ($j = ((int)$coords[1]) - 1; $j <= ((int)$coords[1]) + 1; $j++) {
                if (!isset($octopuses[$i][$j]) || $octopuses[$i][$j] === 0) {
                    continue;
                }
                $octopuses[$i][$j]++;
                if ($octopuses[$i][$j] > 9) {
                    $octopuses[$i][$j] = 0;
                    $newFlashed[] = "$i,$j";
                    $flashes++;
                }
            }
        }
    }
    if (count($newFlashed)) {
        $flashes += flash($newFlashed, $octopuses);
    }

    return $flashes;
}

echo $step . PHP_EOL;
