<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$rules = [];
$ans = 0;
$ans2 = 0;

foreach ($lines as $line) {
    if (str_contains($line, '|')) {
        $ord = explode('|', $line);
        $rules[$ord[0]][] = $ord[1];
    }
    if (str_contains($line, ',')) {
        $numbers = explode(',', $line);
        $ordered = $numbers;
        usort($ordered, function ($a, $b) use ($rules) {
            return isset($rules[(int)$b]) && in_array($a, $rules[(int)$b]) ? 1 : -1;
        });
        if ($ordered === $numbers) {
            $ans += (int)$ordered[(int)(count($ordered) / 2)];
        } else {
            $ans2 += (int)$ordered[(int)(count($ordered) / 2)];
        }
    }
}


echo $ans . ' | ' . $ans2 . PHP_EOL;