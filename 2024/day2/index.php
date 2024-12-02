<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$safe = 0;
$secondSafe = 0;
foreach ($lines as $line) {
    $numbers = explode(' ', $line);
    $original = explode(' ', $line);
    $failed = 0;
    for ($i = 1; $i < count($numbers); $i++) {
        $level = abs($numbers[$i-1] - $numbers[$i]);
        if ($level === 0 || $level > 3 || ($numbers[0] > $numbers[1] && $numbers[$i-1] < $numbers[$i] || $numbers[0] < $numbers[1] && $numbers[$i-1] > $numbers[$i])) {
            if ($failed === count($numbers)+1) {
                continue 2;
            }
            $numbers = $original;
            array_splice($numbers, $failed, 1);
            $i = 0;
            $failed++;
        }
    }
    if ($failed === 0) {
        $safe++;
    }
    $secondSafe++;
}

echo $safe . ' | ' . $secondSafe . PHP_EOL;
