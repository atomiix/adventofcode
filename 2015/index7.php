<?php

$input = file_get_contents('input.txt');
$lines = explode("\n", $input);

$a = 0;
for ($i = 0; $i < 2; $i++) {
    $values = [];
    while (count($values) !== count($lines)) {
        foreach ($lines as $line) {
            [$operation, $signal] = explode(' -> ', $line);
            if ($i === 1 && $signal === 'b') {
                $operation = $a;
            }
            if (preg_match('/^\d+$/', $operation)) {
                $values[$signal] = (int)$operation;
            }
            else if (preg_match('/^\w+$/', $operation)) {
                if (!isset($values[$operation])) {
                    continue;
                }
                $values[$signal] = $values[$operation];
            }
            else if (str_starts_with($operation, 'NOT')) {
                if (!isset($values[substr($operation, 4)])) {
                    continue;
                }
                $values[$signal] = 0xFFFF - $values[substr($operation, 4)];
            }
            else if (preg_match('/.+(AND|OR|LSHIFT|RSHIFT).+/', $operation, $matches)) {
                [$first, $second] = explode(' '.$matches[1].' ', $operation);
                if (!preg_match('/^\d+$/', $first)) {
                    if (!isset($values[$first])) {
                        continue;
                    }
                    $first = $values[$first];
                }
                if (!preg_match('/^\d+$/', $second)) {
                    if (!isset($values[$second])) {
                        continue;
                    }
                    $second = $values[$second];
                }
                if (in_array($matches[1], ['AND', 'OR'])) {
                    $values[$signal] = $matches[1] === 'AND' ? (int)$first & (int)$second : (int)$first | (int)$second;
                } else {
                    $values[$signal] = $matches[1] === 'RSHIFT' ? (int)$first >> (int)$second : (int)$first << (int)$second;
                }
            }
        }
    }
    $a = $values['a'];
    echo $values['a'] . PHP_EOL;
}