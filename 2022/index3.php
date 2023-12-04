<?php

$input = file_get_contents('input.txt');
$lines = explode("\n", $input);

$score = 0;
/*

foreach ($lines as $line) {
    $chars = str_split($line);
    $parts = array_chunk($chars, strlen($line)/2);
    $letter = array_unique(array_merge(array_intersect(...$parts)))[0];
    $score += $letter === strtolower($letter) ? ord($letter) - 96 : ord($letter) - 38;
}

/*/

for ($i = 2; $i < count($lines); $i += 3) {
    $letter = array_unique(array_merge(array_intersect(str_split($lines[$i-2]), str_split($lines[$i-1]), str_split($lines[$i]))))[0];
    $score += $letter === strtolower($letter) ? ord($letter) - 96 : ord($letter) - 38;
}


//*/
echo $score . PHP_EOL;