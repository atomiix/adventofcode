<?php

$input = file_get_contents('input.txt');
$lines = explode("\n", $input);

$niceStrings = 0;

foreach ($lines as $line) {
    $repeatLetter = false;
    $repeatPattern = false;
    $pattern = ['-', '-'];
    foreach (str_split($line) as $letter) {
        $pattern[] = $letter;
        array_shift($pattern);
        if (preg_match('/'.$letter.'.'.$letter.'/', $line)) {
            $repeatLetter = true;
        }
        $i = strpos($line, join('', $pattern));
        if ($i !== false && strpos($line, join('', $pattern), $i+2)) {
            $repeatPattern = true;
        }
    }
    if ($repeatPattern && $repeatLetter) {
        $niceStrings++;
    }
}

echo $niceStrings . PHP_EOL;