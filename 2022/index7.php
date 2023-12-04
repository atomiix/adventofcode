<?php

$input = file_get_contents('input.txt');
$lines = explode("\n", $input);

$tree = ['' => 0];
$pwd = [];
foreach ($lines as $line) {
    if (str_starts_with($line, '$')) {
        if (str_starts_with($line, '$ cd')) {
            if (str_ends_with($line, '/')) {
                $pwd = [''];
            } else if (str_ends_with($line, '..')) {
                array_pop($pwd);
            } else {
                $dir = explode(' ', $line);
                $pwd[] = end($dir);
                $tree[implode('/', $pwd)] = 0;
            }
        }
    }
    if (preg_match('/^(\d+)/', $line, $matches)) {
        $prev = [];
        foreach ($pwd as $dir) {
            $prev[] = $dir;
            $tree[implode('/', $prev)] += (int)$matches[1];
        }
    }
}

echo array_sum(array_filter($tree, fn ($item) => $item <= 100000)) . PHP_EOL;

$needed = 30000000 - (70000000 - $tree['']);
sort($tree);
foreach ($tree as $dir) {
    if ($dir >= $needed) {
        echo $dir . PHP_EOL;
        break;
    }
}