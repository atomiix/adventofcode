<?php

$input = file_get_contents('input.txt');
$decoded = json_decode($input);

preg_match_all('/(-?\d+)/m', $input, $matches);
echo array_sum($matches[1]) . PHP_EOL;

function getTotalInArray($array) {
    $total = 0;
    foreach ($array as $item) {
        if (is_object($array) && $item === "red") {
            return 0;
        }
        if (is_int($item)) {
            $total += $item;
        }
        if (is_array($item) || is_object($item)) {
            $total += getTotalInArray($item);
        }
    }

    return $total;
}

echo getTotalInArray($decoded) . PHP_EOL;