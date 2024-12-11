<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);


$ans1 = 0;
$ans2 = 0;

function testAll($first, $second, &$results1 = [], &$results2 = []) {
    if (is_array($second) && count($second) === 1) {
        $second = $second[0];
    }
    if (is_array($second)) {
        $third = array_shift($second);
        $sum = $first + $third;
        $product = $first * $third;
        $concat = $first . $third;
        $r1 = testAll($sum, $second, $results1, $results2);
        $r2 = testAll($product, $second, $results1, $results2);
        $results1[] = $r1;
        $results1[] = $r2;
        $results2[] = $r1;
        $results2[] = $r2;
        $dummy = [];
        $results2[] = testAll($concat, $second, $dummy, $results2);
        return;
    }

    $results1[] = $first + $second;
    $results1[] = $first * $second;
    $results2[] = $first + $second;
    $results2[] = $first * $second;
    $results2[] = $first . $second;
}

foreach ($lines as $line) {
    [$expected, $numbers] = explode(': ', $line);
    $numbers = explode(' ', $numbers);
    $results1 = [];
    $results2 = [];
    $first = array_shift($numbers);
    testAll($first, $numbers, $results1, $results2);
    if (in_array((int)$expected, $results1)) {
        $ans1 += $expected;
    }
    if (in_array((int)$expected, $results2)) {
        $ans2 += $expected;
    }
}

echo $ans1 . ' | ' . $ans2 . PHP_EOL;
