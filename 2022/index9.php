<?php

$input = file_get_contents('input.txt');
$lines = explode("\n", $input);

$knots = array_fill(0, 10, [0, 0]);
$positions = [[], []];
foreach ($lines as $line) {
    [$direction, $length] = explode(' ', $line);
    for ($i = 0; $i < (int) $length; $i++) {
        if (in_array($direction, ['R', 'L'])) {
            $knots[0][0] += $direction === 'R' ? 1 : -1;
        } else {
            $knots[0][1] += $direction === 'D' ? 1 : -1;
        }
        for ($k = 1; $k < 10; $k++) {
            if (abs($knots[$k][0] - $knots[$k-1][0]) > 1 || abs($knots[$k][1] - $knots[$k-1][1]) > 1) {
                if ($knots[$k][0] !== $knots[$k-1][0]) {
                    $knots[$k][0] += ($knots[$k][0] - $knots[$k-1][0]) > 0 ? -1 : 1;
                }
                if ($knots[$k][1] !== $knots[$k-1][1]) {
                    $knots[$k][1] += ($knots[$k][1] - $knots[$k-1][1]) > 0 ? -1 : 1;
                }
            }
        }
        $positions[0][] = $knots[1][0].','.$knots[1][1];
        $positions[1][] = $knots[9][0].','.$knots[9][1];
    }
}

echo count(array_unique($positions[0])) . PHP_EOL;
echo count(array_unique($positions[1])) . PHP_EOL;