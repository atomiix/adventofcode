<?php

$input = file_get_contents('input.txt');
$lines = explode("\n", $input);

$valid = ['(' => ')', '{' => '}', '[' => ']', '<' => '>'];
$points = [')' => 1, ']' => 2, '}' => 3, '>' => 4];
$scores = [];

foreach ($lines as $line) {
    $stack = [];
    $corrupted = false;
    foreach (str_split($line) as $char) {
        if (in_array($char, $valid) && (empty($stack) || $valid[end($stack)] !== $char)) {
            $corrupted = true;
            break;
        }
        if (in_array($char, array_keys($valid))) {
            $stack[] = $char;
            continue;
        }
        array_pop($stack);
    }
    if (!$corrupted) {
        $score = 0;
        foreach (array_reverse($stack) as $item) {
            $score *= 5;
            $score += $points[$valid[$item]];
        }
        $scores[] = $score;
    }
}

sort($scores);
echo $scores[(int)(count($scores)/2)] . PHP_EOL;