<?php

$input = file_get_contents('input.txt');
$lines = explode("\n", $input);

$paths = [];
$discovered = [];
$current = [0, 0];
$end = [0, 0];
foreach ($lines as $i => $line) {
    $letters = str_split($line);
    foreach ($letters as $j => $letter) {
        if ($letter === 'S') {
            $current = [$i, $j];
        } else if ($letter === 'E') {
            $end = [$i, $j];
        }
        $paths[$i][$j] = ['letter' => $letter, 'distance' => 1];
    }
}
//$current = [2,2];
$discovered[] = implode(',', $current);

while (count($discovered) < count($paths)*count($paths[0])) {

    $value = ord($paths[$current[0]][$current[1]]['letter']);
    if ($value === ord('S') || $value === ord('E')) {
        $value = ord('a');
    }
    $newValue = $current;
    for ($i = -1; $i <= 1; $i++) {
        for ($j = -1; $j <= 1; $j++) {
            if ($i === 0 && $j === 0 || in_array("$i,$j", $discovered) || !isset($paths[$i][$j])) {
                continue;
            } else if (ord($paths[$newValue[0]+$i][$newValue[1]+$j]['letter'])-1 > $value) {
                $paths[$newValue[0]+$i][$newValue[1]+$j]['distance'] = PHP_INT_MAX;;
                continue;
            }
            $paths[$newValue[0]+$i][$newValue[1]+$j]['distance'] = $paths[$newValue[0]][$newValue[1]]['distance'] + 1;
        }
    }




    if (isset($paths[$current[0]-1][$current[1]]) && ord($paths[$current[0]-1][$current[1]]['letter'])-1 <= $value && !in_array(($current[0]-1).','.$current[1], $discovered)) {
        $newValue = [$current[0]-1, $current[1]];
    }
    if (isset($paths[$current[0]+1][$current[1]]) && ord($paths[$current[0]+1][$current[1]]['letter'])-1 <= $value && !in_array(($current[0]+1).','.$current[1], $discovered)) {
        $newValue = [$current[0]+1, $current[1]];
    }
    if (isset($paths[$current[0]][$current[1]-1]) && ord($paths[$current[0]][$current[1]-1]['letter'])-1 <= $value && !in_array($current[0].','.($current[1]-1), $discovered)) {
        $newValue = [$current[0], $current[1]-1];
    }
    if (isset($paths[$current[0]][$current[1]+1]) && ord($paths[$current[0]][$current[1]+1]['letter'])-1 <= $value && !in_array($current[0].','.($current[1]+1), $discovered)) {
        $newValue = [$current[0], $current[1]+1];
    }


    $discovered[] = implode(',', $newValue);


    $current = $newValue;

    var_dump($newValue);
    foreach ($paths as $path) {
        foreach ($path as $char) {
            echo $char['distance'] . ' ';
        }
        echo PHP_EOL;
    }
    echo PHP_EOL;

}

//var_dump($paths);
//var_dump($current);
//var_dump($end);

foreach ($paths as $path) {
    foreach ($path as $char) {
        echo $char['distance'] . ' ';
    }
    echo PHP_EOL;
}