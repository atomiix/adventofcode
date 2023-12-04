<?php

$input = file_get_contents('input.txt');
$monkeysInput = explode("\n\n", $input);

$monkeys = [];

foreach ($monkeysInput as $monkey) {
    $info = explode("\n", $monkey);
    $monkeys[] = [
        'items' => explode(', ', explode(': ', $info[1])[1]),
        'operation' => array_slice(explode(' ', $info[2]), -2),
        'cond' => explode(' ', $info[3])[5],
        'true' => (int) explode(' ', $info[4])[9],
        'false' => (int) explode(' ', $info[5])[9],
        'count' => 0,
    ];
}

$mod = array_product(array_map(fn ($item) => $item['cond'], $monkeys));
for ($i = 0; $i < 10000; $i++) {
    foreach ($monkeys as &$monkey) {
        while (count($monkey['items'])) {
            $item = array_shift($monkey['items']);
            $old = $item;
            if ($monkey['operation'][0] === '*') {
                $item = bcmul($item, $monkey['operation'][1] === 'old' ? $item : $monkey['operation'][1]);
            } else if ($monkey['operation'][0] === '+') {
                $item = bcadd($item, $monkey['operation'][1] === 'old' ? $item : $monkey['operation'][1]);
            } else if ($monkey['operation'][0] === '-') {
                $item = bcsub($item, $monkey['operation'][1] === 'old' ? $item : $monkey['operation'][1]);
            }
            $item = bcmod($item, $mod);
            $monkeys[bcmod($item, $monkey['cond']) === '0' ? $monkey['true'] : $monkey['false']]['items'][] = $item;
            $monkey['count']++;
        }
    }
}

$counts = array_map(fn($item) => $item['count'], $monkeys);
rsort($counts);
echo array_product(array_slice($counts, 0, 2)) . PHP_EOL;