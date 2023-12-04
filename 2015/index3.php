<?php

$input = file_get_contents('input.txt');
$houses = ["0,0" => 1];
$x = [0, 0];
$y = [0, 0];
$index = 0;
foreach (str_split($input) as $dir) {
    if ($dir === '>') {
        $x[$index%2]++;
    } else if ($dir === '^') {
        $y[$index%2]--;
    } else if ($dir === 'v') {
        $y[$index%2]++;
    } else {
        $x[$index%2]--;
    }
    $i = $x[$index%2] . ',' . $y[$index%2];
    $houses[$i] = 1;
    $index++;
}

echo array_sum($houses) . PHP_EOL;