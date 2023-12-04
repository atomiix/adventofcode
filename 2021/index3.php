<?php

$input = file_get_contents('input.txt');
$lines = explode("\n", $input);
$oxygenLines = $lines;
$co2Lines = $lines;

$length = strlen($lines[0]);
$ones = array_fill(0, $length, 0);

$oxygen = 0;
$co2 = 0;

for ($i = 0; $i < $length; $i++) {
    $count = 0;
    foreach ($oxygenLines as $line) {
        if ($line[$i] === '1') {
            $count++;
        }
    }
    $keep = $count/count($oxygenLines) >= 0.5 ? '1' : '0';
    foreach ($oxygenLines as $j => $line) {
        if ($line[$i] !== $keep && count($oxygenLines) > 1) {
            unset($oxygenLines[$j]);
        }
    }
    $count = 0;
    foreach ($co2Lines as $line) {
        if ($line[$i] === '1') {
            $count++;
        }
    }
    $keep = $count/count($co2Lines) < 0.5 ? '1' : '0';
    foreach ($co2Lines as $j => $line) {
        if ($line[$i] !== $keep && count($co2Lines) > 1) {
            unset($co2Lines[$j]);
        }
    }
}

$oxygenBits = current($oxygenLines);
$co2Bits = current($co2Lines);

for ($i = 0; $i < $length; $i++) {
    $oxygen |= ((int) $oxygenBits[$i] << $length - $i - 1);
    $co2 |= ((int) $co2Bits[$i] << $length - $i - 1);
}

echo $oxygen * $co2 . PHP_EOL;