<?php

$input = file_get_contents('input.txt');
$lines = explode("\n", $input);

$paths = [];

foreach ($lines as $line) {
    $caves = explode('-', $line);
    if (!isset($paths[$caves[0]])) {
        $paths[$caves[0]] = [];
    }
    if ($caves[1] !== 'end' && !isset($paths[$caves[1]])) {
        $paths[$caves[1]] = [];
    }
    if (!in_array($caves[1], $paths[$caves[0]])) {
        $paths[$caves[0]][] = $caves[1];
    }
    if ($caves[0] !== 'start' && $caves[1] !== 'end' && !in_array($caves[0], $paths[$caves[1]])) {
        $paths[$caves[1]][] = $caves[0];
    }
}

function findPath($startCave, $paths, $currentPath = [])
{
    $newPaths = [];
    foreach ($paths[$startCave] as $cave) {
        if ($cave === 'end') {
            $newPaths[] = array_merge($currentPath, [$cave]);
        } else {
            $alreadyTwice = false;
            foreach (array_count_values($currentPath) as $key => $value) {
                if (strtolower($key) === $key && $value === 2) {
                    $alreadyTwice = true;
                    break;
                }
            }
            if (strtoupper($cave) === $cave || !in_array($cave, $currentPath) || !$alreadyTwice && $cave !== 'start') {
                $newPaths = array_merge($newPaths, findPath($cave, $paths, array_merge($currentPath, [$cave])));
            }
        }
    }

    return $newPaths;
}

echo count(findPath('start', $paths, ['start'])) . PHP_EOL;