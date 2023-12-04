<?php

$input = file_get_contents('input.txt');
$lines = explode("\n", $input);
$scanners = [];

$beacons = [];
foreach ($lines as $line) {
    if (empty($line)) {
        $scanners[] = $beacons;
        $beacons = [];
        continue;
    }
    if (str_starts_with($line, '---')) {
        continue;
    }
    $beacons[] = array_map(fn ($item) => (int) $item, explode(',', $line));
}

foreach ($scanners as $i => $scanner) {
    foreach ($scanners as $j => $scanner2) {

    }
}