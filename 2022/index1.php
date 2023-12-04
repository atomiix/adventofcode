<?php

$input = file_get_contents('input.txt');
$lines = explode("\n", $input);

$calories = [];
$tmpMax = 0;
foreach ($lines as $line) {
    if ($line === '') {
        $calories[] = $tmpMax;
        $tmpMax = 0;
        continue;
    }
    $tmpMax += $line;
}
$calories[] = $tmpMax;
rsort($calories);

echo $calories[0] + $calories[1] + $calories[2].PHP_EOL;