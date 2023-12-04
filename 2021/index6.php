<?php

$input = file_get_contents('input.txt');
$fish = array_map(fn ($item) => (int) $item, explode(",", $input));
$states = [];

for ($i = 0; $i < 9; $i++) {
    $states[$i] = 0;
}
foreach ($fish as $f) {
    $states[$f]++;
}

for ($i = 0; $i < 256; $i++) {
    $new = 0;
    foreach ($states as $state => $nb) {
        if ($state == 0) {
            $new = $nb;
        } else {
            $states[$state-1] = $nb;
        }
    }
    $states[8] = $new;
    $states[6] += $new;
}

echo array_sum($states) . PHP_EOL;