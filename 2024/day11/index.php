<?php

$line = current(file('input.txt', FILE_IGNORE_NEW_LINES));

$numbers = explode(" ", $line);
$total = 0;
function blink(string $number, int $level, array &$computed = []): int
{
    if ($level === 1) {
        return $number !== '0' && strlen($number) % 2 === 0 ? 2 : 1;
    }
    if (!isset($computed[$number][$level])) {
        $sum = 0;
        if ($number === '0') {
            $sum += blink('1', $level - 1, $computed);
        } elseif (strlen($number) % 2 === 0) {
            $left = substr($number, 0, strlen($number)/2);
            $right = str_pad(ltrim(substr($number, strlen($number)/2), '0'), 1, '0');
            $sum += blink($left, $level - 1, $computed);
            $sum += blink($right, $level - 1, $computed);
        } else {
            $sum += blink((string)($number * 2024), $level - 1, $computed);
        }
        $computed[$number][$level] = $sum;
    }

    return $computed[$number][$level];
}

$computed = [];
$ans1 = 0;
$ans2 = 0;
foreach ($numbers as $number) {
    $ans1 += blink($number, 25, $computed);
    $ans2 += blink($number, 75, $computed);
}

echo $ans1 . ' | ' . $ans2 . PHP_EOL;
