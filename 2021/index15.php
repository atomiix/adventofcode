<?php

$input = file_get_contents('input.txt');
$lines = explode("\n", $input);

$nodes = [];
$exploredNodes = [];

for ($ry = 0; $ry < 5; $ry++) {
    for ($rx = 0; $rx < 5; $rx++) {
        foreach ($lines as $i => $line) {
            foreach (str_split($line) as $j => $weight) {
                $y = count($lines) * $ry + $i;
                $x = strlen($lines[0]) * $rx + $j;
                $nodes["$y,$x"] = (((int) $weight) + $rx + $ry) % 9;
                if ($nodes["$y,$x"] === 0) {
                    $nodes["$y,$x"] = 9;
                }
            }
        }
    }
}

$exploredNodes["0,0"] = 0;
$queue = ["0,0"];
$bottomRight = count($lines) * 5 - 1 . ',' . strlen($lines[0]) * 5 - 1;

while (!empty($queue)) {
    [$y, $x] = explode(',', array_shift($queue));
    $neighbours = [
        ($y + 1) . ',' . $x,
        ($y - 1) . ',' . $x,
        $y . ',' . ($x + 1),
        $y . ',' . ($x - 1),
    ];
    foreach ($neighbours as $neighbour) {
        if (isset($nodes[$neighbour])) {
            $distance = $exploredNodes["$y,$x"] + $nodes[$neighbour];
            if (!isset($exploredNodes[$neighbour]) || $distance < $exploredNodes[$neighbour]) {
                $exploredNodes[$neighbour] = $distance;
                $queue[] = $neighbour;
            }
        }
    }
}

echo $exploredNodes[$bottomRight] . PHP_EOL;