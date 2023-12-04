<?php

$input = file_get_contents('input.txt');
$lines = explode("\n", $input);

$visibleTrees = count($lines) * 2 + strlen(reset($lines)) * 2 - 4;
for ($i = 1; $i < count($lines) - 1; $i++) {
    for ($j = 1; $j < strlen($lines[$i]) - 1; $j++) {
        $left = array_slice(str_split($lines[$i]), 0, $j);
        $right = array_slice(str_split($lines[$i]), $j + 1);
        $filter = fn ($item) => (int) $item < (int) $lines[$i][$j];
        if ($j === count(array_filter($left, $filter)) || strlen($lines[$i]) - $j - 1 === count(array_filter($right, $filter))) {
            $visibleTrees++;
            continue;
        }
        $top = array_map(fn ($item) => $item[$j], $lines);
        $bottom = array_splice($top, $i);
        array_shift($bottom);
        if ($i === count(array_filter($top, $filter)) || count($bottom) === count(array_filter($bottom, $filter))) {
            $visibleTrees++;
        }
    }
}

echo $visibleTrees . PHP_EOL;

$max = 0;
foreach ($lines as $i => $line) {
    foreach (str_split($line) as $j => $tree) {
        $scores = [0, 0, 0, 0];
        $top = array_map(fn ($item) => $item[$j], $lines);
        $bottom = array_splice($top, $i);
        array_shift($bottom);
        $borders = [
            array_reverse(array_slice(str_split($line), 0, $j)),
            array_slice(str_split($line), $j + 1),
            array_reverse($top),
            $bottom,
        ];
        foreach ($borders as $b => $border) {
            foreach ($border as $borderTree) {
                $scores[$b]++;
                if ((int)$borderTree >= (int)$tree) {
                    break;
                }
                $lastTree = (int) $borderTree;
            }
        }
        $score = array_product(array_filter($scores, fn ($item) => $item > 0));
        if ($score > $max) {
            $max = $score;
        }
    }
}

echo $max . PHP_EOL;
