<?php

$input = sprintf('%s/%s', __DIR__, isset($argv[2]) ? 'test.txt' : 'input.txt');
$lines = explode("\n", file_get_contents($input));

[,$seedsline] = explode(': ', array_shift($lines));
$seeds = explode(' ', $seedsline);
$p2Seeds = array_chunk($seeds, 2);
$location = [];

$srcs = [];
$dests = [];
foreach ($lines as $line) {
    if (str_ends_with($line, 'map:')) {
        continue;
    }
    if ($line === "")  {
        if (!empty($srcs)) {
            foreach ($seeds as &$seed) {
                foreach ($srcs as $s => $range) {
                    if ($seed >= $s && $seed <= $s + $range) {
                        $seed = $dests[$s]-$s+$seed;
                        break;
                    }
                }
            }
            foreach ($p2Seeds as $seed2) {
                foreach ($srcs as $s => $range) {
                    if ($seed2[0]+$seed2[1] >= $s && $seed2[0] <= $s + $range) {
                        $start = $seed2[0] >= $s ? $seed2[0] : $s;
                        $length = min($seed2[0]+$seed2[1], $s + $range) - $start;
                        $newp2seeds[] = [$start, $length];
                    }
                }
            }
            $p2Seeds = $newp2seeds;
            $newp2seeds = [];
        }
        [$category,] = explode(' ', $line);
        $srcs = [];
        $dests = [];
        continue;
    }

    [$dest, $src, $range] = explode(' ', $line);
    $srcs[(int)$src] = (int)$range;
    $dests[(int)$src] = (int)$dest;
}

echo min($seeds) . PHP_EOL;
var_dump($p2Seeds);
