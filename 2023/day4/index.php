<?php

$lines = file('input.txt');

$total = 0;
$cards = [];
foreach ($lines as $k => $card) {
    if (!isset($cards[$k])) {
        $cards[$k] = 0;
    }
    $cards[$k]++;
    [$nn, $numbers] = explode(': ', trim($card));
    [$list, $mine] = explode(' | ', $numbers);
    $count = count(array_filter(array_intersect(explode(' ', $list), explode(' ', $mine))));
    $pow = (int)(pow(2, $count)/2);
    if ($pow > 0) {
        for ($i = 1; $i <= $count; $i++) {
            if (!isset($cards[$k+$i])) {
                $cards[$k+$i] = 0;
            }
            $cards[$k+$i] += $cards[$k];
        }
    }
    $total += $pow;
}

echo $total . PHP_EOL;
echo array_sum($cards) . PHP_EOL;
