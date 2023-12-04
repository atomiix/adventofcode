<?php

$lines = file('input.txt');

$numbers = [];
$symbols = [];
foreach ($lines as $i => $line) {
    $chars = str_split(trim($line));
    foreach ($chars as $j => $char) {
        if ($char === '.') {
            continue;
        }
        if (is_numeric($char)) {
            $k = $j;
            while(is_numeric($chars[$k-1] ?? null)) {
                --$k;
            }
            if ($k === $j) {
                $numbers[$i][$k] = $char;
            } else {
                $numbers[$i][$k] .= $char;
            }
        } else {
            $symbols[$i][$j] = $char;
        }
    }
}

$result = 0;
$mul = [];
foreach ($numbers as $i => $number) {
    foreach ($number as $j => $n) {
        for ($ii = $i - 1; $ii <= $i+1; $ii++) {
            for ($jj = $j - 1; $jj <= $j+strlen((string)$n); $jj++) {
                if (isset($symbols[$ii][$jj])) {
                    if ($symbols[$ii][$jj] === '*') {
                        $mul["$ii,$jj"][] = $n;
                    }
                    $result += $n;
                    continue 2;
                }
            }
        }
    }
}
echo $result . PHP_EOL;
echo array_sum(array_map(fn ($item) => array_product($item), array_filter($mul, fn ($item) => count($item) === 2))) . PHP_EOL;