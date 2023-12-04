<?php

$newString = '1113222113';
$input = '';
for ($i = 0; $i < 50; $i++) {
    $input = $newString;
    $newString = '';
    $last = [$input[0], 1];
    foreach (str_split($input) as $index => $digit) {
        if ($index === 0) {
            continue;
        }
        if ($last[0] === $digit) {
            $last[1]++;
        } else {
            $newString .= $last[1].$last[0];
            $last = [$digit, 1];
        }
    }
    $newString .= $last[1].$last[0];
    if ($i === 39) {
        echo strlen($newString) . PHP_EOL;
    }
}

echo strlen($newString) . PHP_EOL;