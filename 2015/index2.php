<?php

$input = file_get_contents('input.txt');
$lines = explode("\n", $input);

$total = 0;
foreach ($lines as $line) {
    $sides = array_map(fn ($item) => (int) $item, explode('x', $line));
    sort($sides);
    $length = $sides[0] + $sides[0] + $sides[1] + $sides[1] + $sides[0] * $sides[1] * $sides[2];
    $total += $length;
}

echo $total . PHP_EOL;