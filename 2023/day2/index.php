<?php

$lines = file('input.txt');

$max = ['red' => 12, 'green' => 13, 'blue' => 14];
$possible = 0;
$powers = 0;

foreach ($lines as $line) {
    [$name, $cubes] = explode(': ', trim($line));
    $games = explode('; ', $cubes);
    $min = ['red' => 0, 'green' => 0, 'blue' => 0];
    $skip = false;
    foreach ($games as $game) {
        $count = ['red' => 0, 'green' => 0, 'blue' => 0];
        foreach (explode(', ', $game) as $colors) {
            [$value, $color] = explode(' ', $colors);
            $count[$color] += (int) $value;
            $min[$color] = max($min[$color], (int) $value);
        }
        if ($count['red'] > $max['red'] || $count['green'] > $max['green'] || $count['blue'] > $max['blue']) {
            $skip = true;
        }
    }
    $powers += array_product($min);
    if (!$skip) {
        [, $value] = explode(' ', $name);
        $possible += (int)$value;
    }
}

echo $possible . PHP_EOL;
echo $powers . PHP_EOL;