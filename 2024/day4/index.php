<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$words = 0;
$words2 = 0;
foreach ($lines as $i => $line) {
    foreach (str_split($line) as $j => $char) {
        $w = substr($line, $j, 4);
        $w1 = $char;
        $w2 = $char;
        $w3 = $char;
        $p2w1 = '';
        $p2w2 = '';
        for ($k = 1; $k < 4; $k++) {
            $w1 .= $lines[$i+$k][$j+$k] ?? '';
            $w2 .= $lines[$i-$k][$j+$k] ?? '';
            $w3 .= $lines[$i+$k][$j] ?? '';
        }
        for ($k = -1; $k <= 1; $k++) {
            $p2w1 .= $lines[$i+$k][$j+$k] ?? '';
            $p2w2 .= $lines[$i-$k][$j+$k] ?? '';
        }
        if ($w === 'XMAS' || $w === 'SAMX') {
            $words++;
        }
        if ($w1 === 'XMAS' || $w1 === 'SAMX') {
            $words++;
        }
        if ($w2 === 'XMAS' || $w2 === 'SAMX') {
            $words++;
        }
        if ($w3 === 'XMAS' || $w3 === 'SAMX') {
            $words++;
        }
        if (($p2w1 === 'MAS' || $p2w1 === 'SAM') && ($p2w2 === 'MAS' || $p2w2 === 'SAM')) {
            $words2++;
        }
    }
}

echo $words . ' | ' . $words2 . PHP_EOL;
