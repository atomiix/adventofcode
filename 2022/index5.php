<?php

$input = file_get_contents('input.txt');
$lines = explode("\n", $input);

/*
$part = 1;
/*/
$part = 2;
//*/
$stacksCount = ceil(strlen($lines[0])/4);
$stacks = [];

foreach ($lines as $line) {
    if (str_starts_with($line, 'move')) {
        preg_match('/move (\d+) from (\d+) to (\d+)/', $line, $matches);
        if ($part === 1) {
            array_unshift($stacks[(int) $matches[3] - 1], ...array_reverse(array_splice($stacks[(int)$matches[2] - 1], 0, (int)$matches[1])));
        } else {
            array_unshift($stacks[(int) $matches[3] - 1], ...array_splice($stacks[(int)$matches[2] - 1], 0, (int)$matches[1]));
        }
    } else if (!empty($line) && !str_starts_with($line, '1')) {
        preg_match_all('/(?:[\s]{3}|\[(\w)\])\s?+/', $line, $matches);
        foreach ($matches[1] as $i => $match) {
            if (!isset($stacks[$i])) {
                $stacks[$i] = [];
            }
            if (empty($match)) {
                continue;
            }
            $stacks[$i][] = $match;
        }
    }
}

echo implode('', array_map(fn ($items) => reset($items), $stacks)) . PHP_EOL;
