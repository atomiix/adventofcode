<?php

$input = file_get_contents('input.txt');
$count = 0;
$pos = 0;
foreach (str_split($input) as $char) {
    $pos++;
    if ($char === '(') {
        $count++;
    } else {
        $count--;
    }
    if ($count === -1) {
        var_dump($pos);
        die();
    }
}

var_dump($count);