<?php

$line = current(file('input.txt', FILE_IGNORE_NEW_LINES));

$blocks1 = [];
$blocks2 = [];
$index = 0;

foreach (str_split($line) as $i => $char) {
    if ((int)$char === 0) {
        continue;
    }
    if ($i % 2 === 0) {
        $blocks1 = array_merge($blocks1, array_fill(0, (int)$char, $index));
        $blocks2[] = ['type' => 'file', 'length' => (int)$char, 'id' => $index];
        $index++;
    } else {
        $blocks1 = array_merge($blocks1, array_fill(0, (int)$char, '.'));
        $blocks2[] = ['type' => 'freespace', 'length' => (int)$char];
    }
}

for ($i = 0; $i < count($blocks1); $i++) {
    if ($blocks1[$i] === '.') {
        while (($popped = array_pop($blocks1)) === '.') {}
        $blocks1[$i] = $popped;
    }
}


for ($i = count($blocks2) - 1; $i > 0; $i--) {
    $block = $blocks2[$i];
    if ($block['type'] === 'freespace') {
        continue;
    }

    for ($j = 0; $j < $i; $j++) {
        $freespaceBlock = $blocks2[$j];
        if ($freespaceBlock['type'] === 'file') {
            continue;
        }

        if ($freespaceBlock['length'] >= $block['length']) {
            array_splice($blocks2, $i, 1, [['type' => 'freespace', 'length' => $block['length']]]);
            $blocks2[$j] = ['type' => 'file', 'length' => $block['length'], 'id' => $block['id']];
            $diff = $freespaceBlock['length'] - $block['length'];
            if ($diff > 0) {
                array_splice($blocks2, $j+1, 0, [['type' => 'freespace', 'length' => $diff]]);
                $i++;
            }
            continue 2;
        }
    }
}

$result1 = 0;
$result2 = 0;
$index = 0;

foreach ($blocks1 as $i => $block) {
    $result1 += $i * $block;
}

foreach ($blocks2 as $i => $block) {
    if ($block['type'] === 'freespace') {
        $index += $block['length'];
        continue;
    }
    for ($j = 0; $j < $block['length']; $j++) {
        $result2 += $index * $block['id'];
        $index++;
    }
}

echo $result1 . ' | ' . $result2 . PHP_EOL;
