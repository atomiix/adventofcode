<?php

$input = file_get_contents('input.txt');
$lines = explode("\n", $input);

$score = 0;
/*

foreach ($lines as $line) {
    $pairs = array_map(fn ($pair) => explode('-', $pair), explode(',', $line));
    if ($pairs[0][0] <= $pairs[1][0] && $pairs[0][1] >= $pairs[1][1] || $pairs[1][0] <= $pairs[0][0] && $pairs[1][1] >= $pairs[0][1]) {
        $score++;
    }
}

/*/

foreach ($lines as $line) {
    $pairs = array_map(fn ($pair) => explode('-', $pair), explode(',', $line));
    if ($pairs[0][0] <= $pairs[1][0] && $pairs[0][1] >= $pairs[1][0] || $pairs[0][0] <= $pairs[1][1] && $pairs[0][1] >= $pairs[1][1]
        || $pairs[1][0] <= $pairs[0][0] && $pairs[1][1] >= $pairs[0][0] || $pairs[1][0] <= $pairs[0][1] && $pairs[1][1] >= $pairs[0][1]
    ) {
        $score++;
    }
}

//*/

echo $score . PHP_EOL;