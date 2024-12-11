<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);


$paths = [];
foreach ($lines as $y => $line) {
    foreach (str_split($line) as $x => $char) {
        if ($char === '0') {
            $paths["$x,$y"] = [];
            branches($lines, $x, $y, 0, $paths["$x,$y"]);
        }
    }
}

function branches($grid, $x, $y, $level, &$paths): void
{
    $tries = [[$x-1, $y], [$x+1, $y], [$x, $y-1], [$x, $y+1]];

    foreach ($tries as $try) {
        $line = str_split($grid[$try[1]] ?? '');
        $l = (int)($line[$try[0]] ?? -1);

        if ($l === 0 && $line[$try[0]] === '.') {
            continue;
        }

        if ($l === $level+1) {
            if ($l === 9) {
                $paths[] = implode(',', $try);
                continue;
            }
            branches($grid, $try[0], $try[1], $l, $paths);
        }
    }
}

$ans1 = 0;
$ans2 = 0;
foreach ($paths as $path) {
    $ans1 += count(array_unique($path));
    $ans2 += count($path);
}

echo $ans1 .  ' | ' . $ans2 . PHP_EOL;
