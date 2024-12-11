<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$antennas = [];
$nodes1 = [];
$nodes2 = [];

foreach ($lines as $i => $line) {
    foreach (str_split($line) as $j => $char) {
        if ($char !== '.') {
            $antennas[$char][] = [$i, $j];
        }
    }
}

foreach ($antennas as $frequency => $positions) {
    foreach ($positions as $i => $position) {
        foreach ($positions as $j => $position2) {
            if ($i === $j) {
                continue;
            }
            $diff1 = $position[0] - $position2[0];
            $diff2 = $position[1] - $position2[1];
            $added1 = [$position[0] + $diff1, $position[1] + $diff2];
            $added2 = [$position2[0] - $diff1, $position2[1] - $diff2];
            $continue1 = true;
            $continue2 = true;
            $part11 = false;
            $part12 = false;
            $nodes2[] = implode(',', $position);
            $nodes2[] = implode(',', $position2);
            while ($continue1) {
                if ($added1[0] >= 0 && $added1[0] < count($lines) && $added1[1] >= 0 && $added1[1] < count($lines)) {
                    if (!$part11) {
                        $nodes1[] = implode(',', $added1);
                        $part11 = true;
                    }
                    $nodes2[] = implode(',', $added1);
                    $added1 = [$added1[0] + $diff1, $added1[1] + $diff2];
                } else {
                    $continue1 = false;
                }
            }
            while ($continue2) {
                if ($added2[0] >= 0 && $added2[0] < count($lines) && $added2[1] >= 0 && $added2[1] < count($lines)) {
                    if (!$part12) {
                        $nodes1[] = implode(',', $added2);
                        $part12 = true;
                    }
                    $nodes2[] = implode(',', $added2);
                    $added2 = [$added2[0] - $diff1, $added2[1] -$diff2];
                } else {
                    $continue2 = false;
                }
            }
        }
    }
}

echo count(array_unique($nodes1)) . ' | ' . count(array_unique($nodes2)) . PHP_EOL;
