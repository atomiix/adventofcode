<?php

$input = file_get_contents('input.txt');
$lines = explode("\n", $input);

$numbers = explode(',', array_shift($lines));

$boards = [];
$markedNumbers = [];
$winBoards = [];
$i = -1;
foreach ($lines as $line) {
    if ($line === "") {
        $boards[++$i] = [];
        continue;
    }
    $boards[$i][] = array_values(array_filter(explode(' ', trim($line)), fn ($item) => $item !== ''));
}

foreach ($numbers as $number) {
    $markedNumbers[] = $number;
    foreach ($boards as $i => $board) {
        $winningCol = [0, 0, 0, 0, 0];
        foreach ($board as $rows) {
            $winningRow = 0;
            foreach ($rows as $j => $n) {
                if (in_array($n, $markedNumbers)) {
                    $winningRow++;
                    $winningCol[$j]++;
                    if ($winningRow === 5 || in_array(5, $winningCol)) {
                        if (!in_array($i, $winBoards)) {
                            $winBoards[] = $i;
                        }
                        if (count($winBoards) !== count($boards)) {
                            continue;
                        }
                        $sum = 0;
                        foreach ($board as $r) {
                            foreach ($r as $nn) {
                                if (!in_array($nn, $markedNumbers)) {
                                    $sum += (int) $nn;
                                }
                            }
                        }
                        echo ($sum * (int) $number) . PHP_EOL;
                        die();
                    }
                }
            }
        }
    }
}