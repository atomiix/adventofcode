<?php

const hexMap = [
    '0' => '0000', '1' => '0001', '2' => '0010', '3' => '0011', '4' => '0100', '5' => '0101',
    '6' => '0110', '7' => '0111', '8' => '1000', '9' => '1001', 'A' => '1010', 'B' => '1011',
    'C' => '1100', 'D' => '1101', 'E' => '1110', 'F' => '1111'
];
const types = [0 => '+', 1 => '*', 2 => 'min', 3 => 'max', 5 => '>', 6 => '<', 7 => '=='];

$input = file_get_contents('input.txt');
$binary = join('', array_map(fn ($item) => hexMap[$item], str_split($input)));
$cursor = 0;

function packets(string $input, int &$cursor) {
    $packets = [];
    $cursor += 3;
    $type = array_search('0' . substr($input, $cursor, 3), hexMap);
    $cursor += 3;
    if ($type === 4) {
        $parts = '';
        while (substr($input, $cursor, 1) === '1') {
            $parts .= substr($input, $cursor + 1, 4);
            $cursor += 5;
        }
        $parts .= substr($input, $cursor + 1, 4);
        $cursor += 5;
        $number = 0;
        for ($i = 0; $i < strlen($parts); $i++) {
            $number |= ($parts[$i] << (strlen($parts) - $i - 1));
        }
        $packets = $number;
    } else {
        $lengthType = 15;
        if (substr($input, $cursor, 1) === '1') {
            $lengthType = 11;
        }
        $cursor++;
        $lengthBinary = substr($input, $cursor, $lengthType);
        $cursor += $lengthType;
        $length = 0;
        for ($i = 0; $i < strlen($lengthBinary); $i++) {
            $length |= ($lengthBinary[$i] << (strlen($lengthBinary) - $i - 1));
        }
        $packets[] = types[$type];
        if ($lengthType === 15) {
            $beforeCursor = $cursor;
            while ($cursor < $beforeCursor + $length) {
                $packets[] = packets($input, $cursor);
            }
        } else {
            for ($i = 0; $i < $length; $i++) {
                $packets[] = packets($input, $cursor);
            }
        }
    }

    return $packets;
}

function flatten(array $packets) {
    $operator = array_shift($packets);
    $operation = [];
    foreach ($packets as $packet) {
        if (is_array($packet)) {
            $operation[] = '(' . flatten($packet) . ')';
        } else {
            $operation[] = $packet;
        }
    }

    if (in_array($operator, ['min', 'max'])) {
        if (count($operation) === 1) {
            return reset($operation);
        }
        return $operator . '(' . join(',', $operation) . ')';
    }

    return join($operator, $operation);
}

$operation = flatten(packets($binary, $cursor));
echo eval("return ((int) $operation);") . PHP_EOL;