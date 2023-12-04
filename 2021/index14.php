<?php

$input = file_get_contents('input.txt');
$lines = explode("\n", $input);

$steps = 40;

$entry = [];
$letters = [];
$templates = [];
$firstLine = array_shift($lines);
array_shift($lines);

foreach (str_split($firstLine) as $k => $letter) {
    if (isset($firstLine[$k+1])) {
        if (!isset($entry[$letter.$firstLine[$k+1]])) {
            $entry[$letter.$firstLine[$k+1]] = 0;
        }
        $entry[$letter.$firstLine[$k+1]]++;
    }
}

foreach ($lines as $line) {
    $t = explode(' -> ', $line);
    $templates[$t[0]] = $t[1];
}


for ($i = 0; $i < $steps; $i++) {
    $newEntry = [];
    foreach ($entry as $item => $value) {
        $it = str_split($item);
        if (!isset($letters[$templates[$item]])) {
            $letters[$templates[$item]] = 0;
        }
        if (!isset($newEntry[$it[0] . $templates[$item]])) {
            $newEntry[$it[0] . $templates[$item]] = 0;
        }
        if (!isset($newEntry[$templates[$item] . $it[1]])) {
            $newEntry[$templates[$item] . $it[1]] = 0;
        }

        $newEntry[$it[0] . $templates[$item]] += $value;
        $newEntry[$templates[$item] . $it[1]] += $value;
    }
    $entry = $newEntry;
}

foreach ($entry as $item => $value) {
    $it = str_split($item);
    foreach ($it as $k => $i) {
        if (!isset($letters[$i])) {
            $letters[$i] = 0;
        }
        $letters[$i] += $value;
    }
}
$letters = array_map(fn ($item) => round($item/2), $letters);
sort($letters);

echo end($letters) - reset($letters) . PHP_EOL;