<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$startX = 0;
$startY = 0;

foreach ($lines as $y => $line) {
    $lines[$y] = str_split($line);
    foreach ($lines[$y] as $x => $value) {
        if ($value === '^') {
            $startX = $x;
            $startY = $y;
            $lines[$y][$x] = '.';
            break;
        }
    }
}

function simulate($map, $x, $y, $direction, array &$visited, array &$visitedWithDirection): bool
{
    $visited["$x,$y"] = true;
    if (isset($visitedWithDirection["$x,$y,$direction"])) {
        return true;
    }
    $visitedWithDirection["$x,$y,$direction"] = true;
    $nextDirection = ['TOP' => 'RIGHT', 'RIGHT' => 'BOTTOM', 'BOTTOM' => 'LEFT', 'LEFT' => 'TOP'];

    $newX = match ($direction) {
        'LEFT' => $x - 1,
        'RIGHT' => $x + 1,
        default => $x,
    };
    $newY = match ($direction) {
        'TOP' => $y - 1,
        'BOTTOM' => $y + 1,
        default => $y,
    };

    $char = $map[$newY][$newX] ?? null;

    $result = false;

    if ($char === '.') {
        $result = simulate($map, $newX, $newY, $direction, $visited, $visitedWithDirection);
    } elseif ($char === '#') {
        $direction = $nextDirection[$direction];
        $result = simulate($map, $x, $y, $direction, $visited, $visitedWithDirection);
    }

    return $result;
}

$visited = [];
$visitedWithDirection = [];
simulate($lines, $startX, $startY, 'TOP', $visited, $visitedWithDirection);

$loop = [];
foreach ($visitedWithDirection as $visitedDirection => $dummy) {
    [$x, $y, $direction] = explode(',', $visitedDirection);
    $obstaclePositionX = match ($direction) {
        'LEFT' => $x - 1,
        'RIGHT' => $x + 1,
        default => $x,
    };
    $obstaclePositionY = match ($direction) {
        'TOP' => $y - 1,
        'BOTTOM' => $y + 1,
        default => $y,
    };
    if (($lines[$obstaclePositionY][$obstaclePositionX] ?? '#') === '#') {
        continue;
    }
    if (isset($loop["$obstaclePositionX,$obstaclePositionY"])) {
        continue;
    }
    $map = $lines;
    $map[$obstaclePositionY][$obstaclePositionX] = '#';
    $visited2 = [];
    $visitedWithDirection2 = [];
    if (simulate($map, $startX, $startY, 'TOP', $visited2, $visitedWithDirection2)) {
        $loop["$obstaclePositionX,$obstaclePositionY"] = true;
    }
}

echo count($visited) . ' | ' . count($loop). PHP_EOL;
