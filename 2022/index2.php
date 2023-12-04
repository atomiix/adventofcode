<?php

$input = file_get_contents('input.txt');
$lines = explode("\n", $input);

$win = ['Z' => 'A', 'X' => 'B', 'Y' => 'C', 'A' => 'Y', 'B' => 'Z', 'C' => 'A'];
$points = ['A' => 1, 'B' => 2, 'C' => 3, 'X' => 1, 'Y' => 2, 'Z' => 3];
$score = 0;

foreach ($lines as $line) {
    [$opponent, $me] = explode(' ', $line);
    $score += $me === 'X'
        ? $points[$win[$win[$opponent]]]
        : ($me === 'Z'
            ? $points[$win[$opponent]] + 6
            : $points[$opponent] + 3
        )
    ;
}

echo $score . PHP_EOL;