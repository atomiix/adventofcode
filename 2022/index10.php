<?php

$input = file_get_contents('input.txt');
$lines = explode("\n", $input);

$a = 1;
$cycle = 0;
$sum = 0;
foreach ($lines as $line) {
    $steps = $line === 'noop' ? 1 : 2;
    for ($i = 0; $i < $steps; $i++) {
        echo abs(($cycle % 40) - $a) <= 1 ? '#' : ' ';
        $cycle++;
        if ($cycle % 40 === 0) {
            echo PHP_EOL;
        }
        if ($cycle === 20 || ($cycle - 20) % 40 === 0) {
            $sum += $a*$cycle;
        }
        if ($i === 1) {
            [, $value] = explode(' ', $line);
            $a += (int) $value;
        }
    }
}

echo $sum . PHP_EOL;