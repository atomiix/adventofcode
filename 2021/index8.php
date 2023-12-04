<?php

$input = file_get_contents('input.txt');
$lines = explode("\n", $input);

$single = [4 => 4, 3 => 7, 2 => 1, 7 => 8]; // missing 0, 2, 3, 5, 6, 9
$numbers = [];

foreach ($lines as $line) {
    $segments = [];
    $entries = explode(' | ', $line);
    foreach (explode(' ', $entries[0]) as $segment) {
        if (in_array(strlen($segment), array_keys($single))) {
            $segments[$single[strlen($segment)]] = $segment;
        }
    }
    foreach (explode(' ', $entries[0]) as $segment) {
        if (in_array($segment, $segments)) {
            continue;
        }
        if (strlen($segment) === 5) {
            $is3 = true;
            $is5 = 0;
            foreach (str_split($segments[7]) as $letter) {
                if (str_contains($segment, $letter) === false) {
                    $is3 = false;
                    break;
                }
            }
            foreach (str_split($segments[4]) as $letter) {
                if (str_contains($segment, $letter) === true) {
                    $is5++;
                }
            }
            if ($is3 === true) {
                $segments[3] = $segment;
            } elseif ($is5 === 3) {
                $segments[5] = $segment;
            } else {
                $segments[2] = $segment;
            }
            continue;
        }
        $is9 = true;
        $is0 = true;
        foreach (str_split($segments[4]) as $letter) {
            if (str_contains($segment, $letter) === false) {
                $is9 = false;
                break;
            }
        }
        foreach (str_split($segments[7]) as $letter) {
            if (str_contains($segment, $letter) === false) {
                $is0 = false;
                break;
            }
        }
        if ($is9 === true) {
            $segments[9] = $segment;
        } elseif ($is0 === true) {
            $segments[0] = $segment;
        } else {
            $segments[6] = $segment;
        }
    }
    $number = '';
    foreach (explode(' ', $entries[1]) as $digit) {
        foreach ($segments as $i => $segment) {
            if (strlen($segment) !== strlen($digit)) {
                continue;
            }
            foreach (str_split($digit) as $letter) {
                if (!str_contains($segment, $letter)) {
                    continue 2;
                }
            }
            $number .= $i;
        }
    }
    $numbers[] = (int) $number;
}

echo array_sum($numbers) . PHP_EOL;