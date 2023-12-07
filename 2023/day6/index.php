<?php

$input = sprintf('%s/%s', __DIR__, isset($argv[2]) ? 'test.txt' : 'input.txt');
$lines = file($input, FILE_IGNORE_NEW_LINES);

[, $timesLine] = explode(':', $lines[0]);
[, $distancesLine] = explode(':', $lines[1]);

$times = array_values(array_filter(explode(' ', $timesLine)));
$distances = array_values(array_filter(explode(' ', $distancesLine)));

$min = [];
foreach ($times as $i => $time) {
    for ($t = 1; $t < $time; $t++) {
        if (($time - $t) * $t > (int)$distances[$i]) {
            $min[$i][] = $t;
        }
    }
}

$time = (int) implode('', $times);
$distance = (int) implode('', $distances);

$min2 = [];
for ($t = 1; $t < $time; $t++) {
    if (($time - $t) * $t > (int)$distance) {
        $min2[] = $t;
    }
}


echo array_product(array_map(fn ($x) => count($x), $min)) . PHP_EOL;
echo count($min2) . PHP_EOL;
