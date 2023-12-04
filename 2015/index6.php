<?php

$input = file_get_contents('input.txt');
$lines = explode("\n", $input);

$lights = [];
$size = 1000;
$on = 0;

for ($i = 0; $i < $size; $i++) {
    $lights[$i] = array_fill(0, $size, 0);
}

foreach ($lines as $line) {
    $instructions = explode(' through ', $line);
    $first = explode(' ', $instructions[0]);
    $action = $first[count($first) === 2 ? 0 : 1];
    $startXY = explode(',', end($first));
    $endXY = explode(',', end($instructions));
    for ($i = $startXY[0]; $i <= $endXY[0]; $i++) {
        for ($j = $startXY[1]; $j <= $endXY[1]; $j++) {
            $before = $lights[$i][$j];
            if ($action === 'toggle') {
                $lights[$i][$j] += 2;
            } else {
                $lights[$i][$j] += $action === 'on' ? 1 : -1;
                $lights[$i][$j] = max(0, $lights[$i][$j]);
            }
            $on += $lights[$i][$j] - $before;
        }
    }
}

echo $on . PHP_EOL;