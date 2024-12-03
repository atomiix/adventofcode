<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$pattern = '/mul\(\d+,\d+\)|do\(\)|don\'t\(\)/';

$answer = 0;
$answer2 = 0;
$enabled = true;
foreach ($lines as $line) {
    preg_match_all($pattern, $line, $matches);
    foreach ($matches[0] as $match) {
        if ($match === 'do()' || $match === 'don\'t()') {
            $enabled = $match === 'do()';
            continue;
        }
        $mul = array_product(explode(',', str_replace(['mul(', ')'], [], $match)));
        $answer += $mul;
        if ($enabled) {
            $answer2 += $mul;
        }
    }
}

echo $answer . ' | '. $answer2 . PHP_EOL;