<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$left = [];
$right = [];

foreach ($lines as $line) {
    [$left[], $right[]] = explode('   ', $line);
}

sort($left);
sort($right);

$diff = 0;
$total = 0;
$count = array_count_values($right);
foreach ($left as $i => $v) {
    $diff += abs($v - $right[$i]);
    $total += ($count[$v] ?? 0) * $v;
}

echo "$diff | $total\n";
