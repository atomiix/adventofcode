<?php

$input = file_get_contents('input.txt');
$lines = explode("\n", $input);

$replace = fn ($match) => $match[0];
$length1 = 0;
$length2 = 0;
foreach ($lines as $line) {
    $length1 += strlen($line) - (strlen(preg_replace('/\\\\"|\\\\\\\\|\\\\x(\d|\w){2}/m', '-', $line)) - 2);
    $length2 += strlen(preg_replace('/["\\\]/m', '--', $line)) + 2 - strlen($line);
}

echo $length1 . PHP_EOL;
echo $length2 . PHP_EOL;