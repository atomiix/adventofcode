<?php

$line = file_get_contents('input.txt');
$chars = str_split($line);

$p1 = false;
$p2 = false;
foreach ($chars as $i => $char) {
    if (!$p1 && count(array_count_values(array_slice($chars, $i, 4))) === 4) {
        $p1 = true;
        echo $i+4 . PHP_EOL;
    }
    if (!$p2 && count(array_count_values(array_slice($chars, $i, 14))) === 14) {
        $p2 = true;
        echo $i+14 . PHP_EOL;
    }
}
