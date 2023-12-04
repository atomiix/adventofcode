<?php

$input = file_get_contents('input.txt');
$lines = explode("\n", $input);

const ignore = ['[', ']', ','];

function explodes(&$chars) {
    $stack = 0;
    foreach ($chars as $i => $char) {
        if ($char === '[') {
            $stack++;
        } else if ($char === ']') {
            $stack--;
        }
        if ($stack > 4 && !in_array($char, ignore, true) && !in_array($chars[$i+2], ignore, true)) {
            for ($j = $i - 2; $j > 0; $j--) {
                if (!in_array($chars[$j], ignore, true)) {
                    $chars[$j] = (string) ($chars[$j] + $char);
                    break;
                }
            }
            for ($j = $i + 4; $j < count($chars); $j++) {
                if (!in_array($chars[$j], ignore, true)) {
                    $chars[$j] = (string) ($chars[$j] + $chars[$i+2]);
                    break;
                }
            }
            array_splice($chars, $i-1, 5, '0');

            return true;
        }
    }
    return false;
}

function split(&$chars) {
    foreach ($chars as $i => $char) {
        if (!in_array($char, ignore, true) && (int) $char >= 10) {
            array_splice($chars, $i, 1, ['[', (string)((int)($char/2)), ',', (string)(round($char/2)), ']']);

            return true;
        }
    }
    return false;
}

$max = 0;
foreach ($lines as $i => $line) {
    foreach ($lines as $j => $line2) {
        if ($i === $j) {
            continue;
        }
        $result = array_merge(['['], str_split($line), [','], str_split($line2), [']']);
        while(explodes($result) || split($result)) {}
        while (count($result) > 1) {
            foreach ($result as $k => $char) {
                if (!in_array($char, ignore, true) && !in_array($result[$k+2], ignore, true)) {
                    $value = 3*(int)$char + 2*(int)$result[$k+2];
                    array_splice($result, $k-1, 5, $value);
                    break;
                }
            }
        }
        if (reset($result) > $max) {
            $max = current($result);
        }
    }
}

echo $max . PHP_EOL;