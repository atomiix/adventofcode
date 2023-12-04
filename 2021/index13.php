<?php

$input = file_get_contents('input.txt');
$lines = explode("\n", $input);

$maxX = 0;
$maxY = 0;

$dots = [];
$folds = [];

foreach ($lines as $line) {
    if (str_starts_with($line, 'fold')) {
        $fold = explode(' ', $line);
        $folds[] = end($fold);
    } else if (!empty($line)) {
        [$x, $y] = explode(',', $line);
        if ($x > $maxX) {
            $maxX = $x;
        }
        if ($y > $maxY) {
            $maxY = $y;
        }
        if (!isset($dots[$y])) {
            $dots[$y] = [];
        }
        $dots[$y][$x] = '#';
    }
}

function fold($dots, $fold, $maxX, $maxY) {
    [$axe, $line] = explode('=', $fold);
    $newDots = [];
    if ($axe === 'y') {
        for ($i = 0; $i <= (int) $line+1; $i++) {
            for ($j = 0; $j <= $maxX; $j++) {
                if (isset($dots[$i][$j]) || isset($dots[(int)$line * 2 - $i][$j])) {
                    if (!isset($newDots[$i])) {
                        $newDots[$i] = [];
                    }
                    $newDots[$i][$j] = '#';
                }
            }
        }
    } else {
        for ($i = 0; $i <= $maxY; $i++) {
            for ($j = 0; $j <= (int)$line+1; $j++) {
                if (isset($dots[$i][$j]) || isset($dots[$i][(int)$line * 2 - $j])) {
                    if (!isset($newDots[$i])) {
                        $newDots[$i] = [];
                    }
                    $newDots[$i][$j] = '#';
                }
            }
        }
    }

    return $newDots;
}

foreach ($folds as $fold) {
    [$axe, $line] = explode('=', $fold);
    $dots = fold($dots, $fold, $maxX, $maxY);
    if ($axe === 'x') {
        $maxX = ((int) $line) - 1;
    } else {
        $maxY = ((int) $line) - 1;
    }
}

$count = 0;

for ($i = 0; $i <= $maxY; $i++) {
    for ($j = 0; $j <= $maxX; $j++) {
        echo $dots[$i][$j] ?? ' ';
        if (isset($dots[$i][$j])) {
            $count++;
        }
    }
    echo PHP_EOL;
}

echo $count . PHP_EOL;