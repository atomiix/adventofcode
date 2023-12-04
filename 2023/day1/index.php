<?php

$lines = file('input.txt');

$find = ['one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
$score1 = 0;
$score2 = 0;
foreach ($lines as $line) {
    $chars = str_split($line);
    $numbers1 = [];
    $numbers2 = [];
    foreach ($chars as $i => $char) {
        if (is_numeric($char)) {
            $numbers1[] = $char;
            $numbers2[] = $char;
        }
        foreach ($find as $j => $number) {
            if (str_starts_with(substr($line, $i), $number)) {
                $numbers2[] = $j + 1;
            }
        }
    }

    $score1 += (int)(reset($numbers1) . end($numbers1));
    $score2 += (int)(reset($numbers2) . end($numbers2));
}

echo $score1 . PHP_EOL;
echo $score2 . PHP_EOL;